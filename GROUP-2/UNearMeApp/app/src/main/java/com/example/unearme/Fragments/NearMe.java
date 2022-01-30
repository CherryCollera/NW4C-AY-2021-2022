package com.example.unearme.Fragments;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.location.Location;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.unearme.SchoolPage;
import com.google.android.gms.maps.model.BitmapDescriptor;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.example.unearme.Adapter.CustomInfoAdapter;
import com.example.unearme.MapRoute;
import com.example.unearme.R;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.Circle;
import com.google.android.gms.maps.model.CircleOptions;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.android.material.slider.Slider;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.Query;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;
import com.google.maps.GeoApiContext;

import org.jetbrains.annotations.NotNull;

import java.util.ArrayList;

public class NearMe extends Fragment implements  GoogleMap.OnInfoWindowClickListener, GoogleMap.OnMarkerClickListener {
    public NearMe() {
        // Required empty public constructor
    }

    GoogleMap mGoogleMap;
    SupportMapFragment mapFragment;
    ArrayList<Marker> schoolMarker = new ArrayList<>();
    Circle mapCircle;
    LatLng latLng;
    private FusedLocationProviderClient mFusedLocationClient;
    private GeoApiContext geoApiContext;
    Location schoolLoc = new Location(LocationManager.GPS_PROVIDER), userLoc = new Location(LocationManager.GPS_PROVIDER);
    double userLocationLat, userLocationLng;
    float circleRadius = 10000;
    Slider slider;

    FirebaseFirestore firestore;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_near_me, container, false);
        slider = view.findViewById(R.id.slider);
        firestore = FirebaseFirestore.getInstance();

        mapFragment = (SupportMapFragment) getChildFragmentManager().findFragmentById(R.id.map_near_me);
        mFusedLocationClient = LocationServices.getFusedLocationProviderClient(getContext());
        if (ActivityCompat.checkSelfPermission(getContext(), Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(getContext(), Manifest.permission.ACCESS_COARSE_LOCATION) == PackageManager.PERMISSION_GRANTED) {
            getLastKnownLocation();

        } else {
            ActivityCompat.requestPermissions(getActivity(), new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 44);
        }

        slider.addOnChangeListener(new Slider.OnChangeListener() {
            @Override
            public void onValueChange(@NonNull @NotNull Slider slider, float value, boolean fromUser) {

                circleRadius = value * 1000;
                mapCircle.remove();
                mapCircle = mGoogleMap.addCircle(new CircleOptions().center(latLng).radius(circleRadius).strokeWidth(3f).strokeColor(Color.RED).fillColor(Color.argb(70,150,50,50)));

                for (Marker marker: schoolMarker){
                    marker.remove();
                }
                showAllSchoolMarker();
            }
        });
        // Inflate the layout for this fragment
        return view;
    }
    private void getLastKnownLocation() {
        if (ActivityCompat.checkSelfPermission(getContext(), Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(getContext(), Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(getActivity(), new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 44);
            //return;
        }
        Task<Location> task = mFusedLocationClient.getLastLocation();
        task.addOnSuccessListener(new OnSuccessListener<Location>() {
            @Override
            public void onSuccess(Location location) {
                if (location != null){
                    mapFragment.getMapAsync(new OnMapReadyCallback() {
                        @Override
                        public void onMapReady(@NonNull @NotNull GoogleMap googleMap) {
                            mGoogleMap = googleMap;
                            mGoogleMap.setInfoWindowAdapter(new CustomInfoAdapter(getContext()));
                            mGoogleMap.setOnMarkerClickListener(NearMe.this::onMarkerClick);
                            mGoogleMap.setOnInfoWindowClickListener(NearMe.this::onInfoWindowClick);
                            userLocationLat = location.getLatitude();
                            userLocationLng = location.getLongitude();
                            userLoc.setLatitude(location.getLatitude());
                            userLoc.setLongitude(location.getLongitude());
                            latLng = new LatLng(location.getLatitude(), location.getLongitude());
                            MarkerOptions options = new MarkerOptions().position(latLng);
                            options.title("Me");
                            options.snippet("user");
                            mGoogleMap.moveCamera(CameraUpdateFactory.newLatLngZoom(latLng, 11));
                            mGoogleMap.addMarker(options).setIcon(bitmapDescriptor(getContext(), R.drawable.user_pin));

                            if (geoApiContext == null){
                                geoApiContext = new GeoApiContext.Builder().apiKey("AIzaSyBjsNSzU4sYw6tIJaIYUbMRg1EHRD2bn1A").build();
                            }
                            //calculateDirections();
                            showAllSchoolMarker();

                            mapCircle = mGoogleMap.addCircle(new CircleOptions().center(latLng).radius(10000.0).strokeWidth(3f).strokeColor(Color.RED).fillColor(Color.argb(70,150,50,50)));



                        }

                    });
                }
            }
        });

    }
    private void showAllSchoolMarker(){

        CollectionReference collectionReference =  firestore.collection("schools");

        collectionReference.get().addOnSuccessListener(new OnSuccessListener<QuerySnapshot>() {
            @Override
            public void onSuccess(QuerySnapshot queryDocumentSnapshots) {

                for (QueryDocumentSnapshot documentSnapshot: queryDocumentSnapshots){

                    Log.d("TAG", "working: " + documentSnapshot.getGeoPoint("location").getLatitude());
                    LatLng latLng = new LatLng(documentSnapshot.getGeoPoint("location").getLatitude(),documentSnapshot.getGeoPoint("location").getLongitude());

                    schoolLoc.setLongitude(latLng.longitude);
                    schoolLoc.setLatitude(latLng.latitude);
                    float distance = userLoc.distanceTo(schoolLoc);
                    Log.d("TAG", "calculateCircle: " + distance);

                    if (distance <= circleRadius){
                        MarkerOptions options = new MarkerOptions().position(latLng);
                        options.title(documentSnapshot.getString("school_name"));
                        options.snippet(documentSnapshot.getString("school_id")+"");
                        options.icon(bitmapDescriptor(getContext(), R.drawable.school));

                        Marker marker = mGoogleMap.addMarker(options);
                        schoolMarker.add(marker);

                    }

                }
            }
        });
    }


    @Override
    public void onInfoWindowClick(@NonNull @NotNull Marker marker) {
        if (!marker.getSnippet().equals("user")){
            final AlertDialog.Builder builder = new AlertDialog.Builder(getContext());
            View view = getLayoutInflater().inflate(R.layout.dialog_map_v2, null);

            TextView title = view.findViewById(R.id.dialog_map_schoolname);
            Button view_school = view.findViewById(R.id.dialog_map_viewschool);
            Button google_maps = view.findViewById(R.id.dialog_map_googlemap);

            builder.setView(view);
            final AlertDialog alertDialog = builder.create();
            alertDialog.getWindow().setBackgroundDrawableResource(R.color.transparent);

            title.setText(marker.getTitle());

            view_school.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    startActivity(new Intent(getContext(), SchoolPage.class).putExtra("school_id", marker.getSnippet()));

                }
            });

            google_maps.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    String latitude = String.valueOf(marker.getPosition().latitude);
                    String longitude = String.valueOf(marker.getPosition().longitude);
                    Uri uri = Uri.parse("google.navigation:q="+latitude+","+longitude);
                    Intent maps = new Intent(Intent.ACTION_VIEW, uri);
                    maps.setPackage("com.google.android.apps.maps");
                    try {
                        if (maps.resolveActivity(getActivity().getPackageManager())!= null){
                            startActivity(maps);
                        }
                    } catch (NullPointerException e){
                        Toast.makeText(getContext(), "Couldn't open map", Toast.LENGTH_SHORT).show();
                    }

                }
            });

            alertDialog.show();
        }

    }

    @Override
    public boolean onMarkerClick(@NonNull @NotNull Marker marker) {
        return false;
    }

    private BitmapDescriptor bitmapDescriptor(Context context, int vectorResId){
        Drawable drawable = ContextCompat.getDrawable(context,vectorResId);
        drawable.setBounds(0,0,drawable.getIntrinsicWidth(),drawable.getIntrinsicHeight());
        Bitmap bitmap = Bitmap.createBitmap(drawable.getIntrinsicWidth(), drawable.getMinimumHeight(), Bitmap.Config.ARGB_8888);
        Canvas canvas = new Canvas(bitmap);
        drawable.draw(canvas);
        return BitmapDescriptorFactory.fromBitmap(bitmap);
    }
}