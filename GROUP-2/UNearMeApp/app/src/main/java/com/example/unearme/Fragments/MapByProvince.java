package com.example.unearme.Fragments;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.drawable.Drawable;
import android.net.Uri;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.example.unearme.Adapter.CustomInfoAdapter;
import com.example.unearme.R;
import com.example.unearme.SchoolPage;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptor;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.Query;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;

import org.jetbrains.annotations.NotNull;

import java.util.ArrayList;
import java.util.List;


public class MapByProvince extends Fragment implements GoogleMap.OnInfoWindowClickListener, GoogleMap.OnMarkerClickListener {

    public MapByProvince() {
        // Required empty public constructor
    }

    FirebaseFirestore firestore;
    List<LatLng> latLngList =new ArrayList<>();
    ArrayList<Marker> schoolMarker = new ArrayList<>();
    GoogleMap mGoogleMap;
    SupportMapFragment mapFragment;


    @SuppressLint("ResourceType")
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_map_by_province, container, false);

        Spinner spinner = view.findViewById(R.id.spinner_province);
        firestore = FirebaseFirestore.getInstance();

        ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(getContext(),R.array.province, android.R.layout.simple_spinner_item);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner.setAdapter(adapter);

       spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
           @Override
           public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
               switch (parent.getItemAtPosition(position).toString()){
                   case "Aurora":
                       showSchoolInProvince("Aurora");
                       break;
                   case "Bataan":
                       showSchoolInProvince("Bataan");
                       break;
                   case "Bulacan":
                       showSchoolInProvince("Bulacan");
                       break;
                   case "Nueva Ecija":
                       showSchoolInProvince("Nueva Ecija");
                       break;
                   case "Pampanga":
                       showSchoolInProvince("Pampanga");
                       break;
                   case "Tarlac":
                       showSchoolInProvince("Tarlac");
                       break;
                   case "Zambales":
                       showSchoolInProvince("Zambales");
                       break;
               }

           }

           @Override
           public void onNothingSelected(AdapterView<?> parent) {

           }
       });

        mapFragment = (SupportMapFragment) getChildFragmentManager().findFragmentById(R.id.map_by_province);

        mapFragment.getMapAsync(new OnMapReadyCallback() {
            @Override
            public void onMapReady(@NonNull @NotNull GoogleMap googleMap) {
                mGoogleMap = googleMap;
                mGoogleMap.setInfoWindowAdapter(new CustomInfoAdapter(getContext()));
                mGoogleMap.setOnMarkerClickListener(MapByProvince.this::onMarkerClick);
                mGoogleMap.setOnInfoWindowClickListener(MapByProvince.this::onInfoWindowClick);
                LatLng latLng = new LatLng(15.377350496106216, 120.78715640168568);
                mGoogleMap.moveCamera(CameraUpdateFactory.newLatLngZoom(latLng, 8));
            }
        });
        // Inflate the layout for this fragment
        return view;
    }

    private void showSchoolInProvince(String province){
        latLngList.clear();
        for (Marker marker: schoolMarker){
            marker.remove();
        }
        CollectionReference collectionReference =  firestore.collection("schools");

        Query query = collectionReference.whereEqualTo("province", province);
        query.get().addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
            @Override
            public void onComplete(@NonNull @NotNull Task<QuerySnapshot> task) {
                if (task.isSuccessful()){
                    for (QueryDocumentSnapshot documentSnapshot: task.getResult()){

                        LatLng latLng = new LatLng(documentSnapshot.getGeoPoint("location").getLatitude(),documentSnapshot.getGeoPoint("location").getLongitude());
                        MarkerOptions options = new MarkerOptions().position(latLng);
                        options.title(documentSnapshot.getString("school_name"));
                        options.snippet(documentSnapshot.getString("school_id")+"");
                        options.icon(bitmapDescriptor(getContext(), R.drawable.school));
                        Marker marker = mGoogleMap.addMarker(options);


                        schoolMarker.add(marker);
                        latLngList.add(latLng);
                        zoomProvince(latLngList);
                        // calculateCircle(latLng);
                    }
                }
            }
        });
    }
    public void zoomProvince(List<LatLng> lstLatLngRoute) {

        if (mGoogleMap == null || lstLatLngRoute == null || lstLatLngRoute.isEmpty()) return;
        LatLngBounds.Builder boundsBuilder = new LatLngBounds.Builder();
        for (LatLng latLngPoint : lstLatLngRoute)
            boundsBuilder.include(latLngPoint);

        int routePadding = 200;
        LatLngBounds latLngBounds = boundsBuilder.build();

        mGoogleMap.animateCamera(
                CameraUpdateFactory.newLatLngBounds(latLngBounds, routePadding),
                1000,
                null
        );
    }
    private BitmapDescriptor bitmapDescriptor(Context context, int vectorResId){
        Drawable drawable = ContextCompat.getDrawable(context,vectorResId);
        drawable.setBounds(0,0,drawable.getIntrinsicWidth(),drawable.getIntrinsicHeight());
        Bitmap bitmap = Bitmap.createBitmap(drawable.getIntrinsicWidth(), drawable.getMinimumHeight(), Bitmap.Config.ARGB_8888);
        Canvas canvas = new Canvas(bitmap);
        drawable.draw(canvas);
        return BitmapDescriptorFactory.fromBitmap(bitmap);
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
}