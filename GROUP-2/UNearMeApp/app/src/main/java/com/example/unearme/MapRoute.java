package com.example.unearme;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

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
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.unearme.Adapter.CustomInfoAdapter;
import com.google.android.gms.internal.maps.zzx;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptor;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CircleOptions;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.maps.model.Polyline;
import com.google.android.gms.maps.model.PolylineOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.EventListener;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.FirebaseFirestoreException;
import com.google.firebase.firestore.Query;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;
import com.google.maps.DirectionsApiRequest;
import com.google.maps.GeoApiContext;
import com.google.maps.PendingResult;
import com.google.maps.internal.PolylineEncoding;
import com.google.maps.model.DirectionsResult;
import com.google.maps.model.DirectionsRoute;

import org.jetbrains.annotations.NotNull;

import java.util.ArrayList;
import java.util.List;
import android.net.Uri;

public class MapRoute extends AppCompatActivity implements GoogleMap.OnInfoWindowClickListener, GoogleMap.OnMarkerClickListener{

    FirebaseFirestore firestore;
    FirebaseAuth firebaseAuth;
    GoogleMap mGoogleMap;
    SupportMapFragment mapFragment;
    private FusedLocationProviderClient mFusedLocationClient;
    private GeoApiContext geoApiContext;
    double userLocationLat, userLocationLng;
    String province, sid, trip_duration, trip_distance;
    Polyline polyline;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map_route);

        firebaseAuth = FirebaseAuth.getInstance();
        firestore = FirebaseFirestore.getInstance();

        Intent intent = getIntent();
        province= intent.getStringExtra("province");
        sid = intent.getStringExtra("school_id");



        mapFragment = (SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.map_view_route);
        mFusedLocationClient = LocationServices.getFusedLocationProviderClient(this);
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) == PackageManager.PERMISSION_GRANTED) {

            getLastKnownLocation();
            showAllSchoolMarker();


        } else {
            ActivityCompat.requestPermissions(MapRoute.this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 44);
        }


    }

    private void getLastKnownLocation() {
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(MapRoute.this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 44);
            return;
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
                            mGoogleMap.setInfoWindowAdapter(new CustomInfoAdapter(MapRoute.this));
                            mGoogleMap.setOnMarkerClickListener(MapRoute.this::onMarkerClick);
                            mGoogleMap.setOnInfoWindowClickListener(MapRoute.this::onInfoWindowClick);
                            userLocationLat = location.getLatitude();
                            userLocationLng = location.getLongitude();
//                            userLoc.setLatitude(location.getLatitude());
//                            userLoc.setLongitude(location.getLongitude());
                            LatLng latLng = new LatLng(location.getLatitude(), location.getLongitude());
                            MarkerOptions options = new MarkerOptions().position(latLng);
                            options.title("Me");
                            options.snippet("user");
                            mGoogleMap.moveCamera(CameraUpdateFactory.newLatLngZoom(latLng, 10));
                            mGoogleMap.addMarker(options).setIcon(bitmapDescriptor(getApplicationContext(), R.drawable.user_pin));

                            if (geoApiContext == null){
                                geoApiContext = new GeoApiContext.Builder().apiKey("AIzaSyBjsNSzU4sYw6tIJaIYUbMRg1EHRD2bn1A").build();
                            }
                            //calculateDirections();
                            showSchoolMarker();


                            //mGoogleMap.addCircle(new CircleOptions().center(latLng).radius(50000.0).strokeWidth(3f).strokeColor(Color.RED).fillColor(Color.argb(70,150,50,50)));


                        }

                    });
                }
            }
        });

    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull @NotNull String[] permissions, @NonNull @NotNull int[] grantResults) {
        if (requestCode == 44){
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED){
                getLastKnownLocation();
            }
        }
    }

    private void calculateDirections(LatLng latLng){
    Log.d("TAG", "calculateDirections: calculating directions.");

    com.google.maps.model.LatLng destination = new com.google.maps.model.LatLng(
            latLng.latitude, latLng.longitude

    );
    DirectionsApiRequest directions = new DirectionsApiRequest(geoApiContext);

    directions.alternatives(false);
    directions.origin(
            new com.google.maps.model.LatLng(
                    userLocationLat,
                    userLocationLng
            )
    );
    directions.destination(destination).setCallback(new PendingResult.Callback<DirectionsResult>() {
        @Override
        public void onResult(DirectionsResult result) {
            trip_distance = "Distance: " + result.routes[0].legs[0].distance;
            trip_duration = "Estimated duration: " + result.routes[0].legs[0].duration;

            addPolylinesToMap(result);
        }

        @Override
        public void onFailure(Throwable e) {
            Toast.makeText(MapRoute.this, "Failed to get directions: " + e.getMessage(), Toast.LENGTH_SHORT).show();

        }
    });
}

    private void addPolylinesToMap(final DirectionsResult result){
        new Handler(Looper.getMainLooper()).post(new Runnable() {
            @Override
            public void run() {
                Log.d("TAG", "run: result routes: " + result.routes.length);

                for(DirectionsRoute route: result.routes){
                    Log.d("TAG", "run: leg: " + route.legs[0].toString());
                    List<com.google.maps.model.LatLng> decodedPath = PolylineEncoding.decode(route.overviewPolyline.getEncodedPath());

                    List<LatLng> newDecodedPath = new ArrayList<>();

                    // This loops through all the LatLng coordinates of ONE polyline.
                    for(com.google.maps.model.LatLng latLng: decodedPath){

//                        Log.d(TAG, "run: latlng: " + latLng.toString());

                        newDecodedPath.add(new LatLng(
                                latLng.lat,
                                latLng.lng
                        ));
                    }

                    polyline = mGoogleMap.addPolyline(new PolylineOptions().addAll(newDecodedPath));
                    polyline.setColor(ContextCompat.getColor(MapRoute.this, R.color.polyline));
                    polyline.setClickable(true);
                    zoomRoute(polyline.getPoints());

                }
            }
        });
    }

    public void zoomRoute(List<LatLng> lstLatLngRoute) {

        if (mGoogleMap == null || lstLatLngRoute == null || lstLatLngRoute.isEmpty()) return;
        LatLngBounds.Builder boundsBuilder = new LatLngBounds.Builder();
        for (LatLng latLngPoint : lstLatLngRoute)
            boundsBuilder.include(latLngPoint);

        int routePadding = 150;
        LatLngBounds latLngBounds = boundsBuilder.build();

        mGoogleMap.animateCamera(
                CameraUpdateFactory.newLatLngBounds(latLngBounds, routePadding),
                600,
                null
        );
    }

    private void showSchoolMarker(){
        DocumentReference documentReference = firestore.collection("schools").document(sid);
        documentReference.get().addOnCompleteListener(new OnCompleteListener<DocumentSnapshot>() {
            @Override
            public void onComplete(@NonNull @NotNull Task<DocumentSnapshot> task) {
                if (task.isSuccessful()){

                    LatLng latLng = new LatLng(task.getResult().getGeoPoint("location").getLatitude(), task.getResult().getGeoPoint("location").getLongitude());
                    MarkerOptions options = new MarkerOptions().position(latLng);
                    options.title(task.getResult().getString("school_name"));
                    options.snippet(task.getResult().getString("school_id")+"");
                    options.icon(bitmapDescriptor(getApplicationContext(), R.drawable.school));
                    mGoogleMap.addMarker(options).showInfoWindow();
                    calculateDirections(latLng);
                }
            }
        });





    }

    private void showAllSchoolMarker(){

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
                        mGoogleMap.addMarker(options).setIcon(bitmapDescriptor(getApplicationContext(), R.drawable.school));
                       // calculateCircle(latLng);
                    }
                }
            }
        });
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
            final AlertDialog.Builder builder = new AlertDialog.Builder(MapRoute.this);
            View view = getLayoutInflater().inflate(R.layout.dialog_map, null);

            TextView title = view.findViewById(R.id.dialog_map_schoolname);
            TextView distance = view.findViewById(R.id.dialog_map_distance);
            TextView duration = view.findViewById(R.id.dialog_map_duration);
            Button view_school = view.findViewById(R.id.dialog_map_viewschool);
            Button google_maps = view.findViewById(R.id.dialog_map_googlemap);

            builder.setView(view);
            final AlertDialog alertDialog = builder.create();
            alertDialog.getWindow().setBackgroundDrawableResource(R.color.transparent);

            title.setText(marker.getTitle());
            distance.setText(trip_distance);
            duration.setText(trip_duration);

            view_school.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    startActivity(new Intent(MapRoute.this, SchoolPage.class).putExtra("school_id", marker.getSnippet()));

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
                        if (maps.resolveActivity(MapRoute.this.getPackageManager())!= null){
                            startActivity(maps);
                        }
                    } catch (NullPointerException e){
                        Toast.makeText(MapRoute.this, "Couldn't open map", Toast.LENGTH_SHORT).show();
                    }

                }
            });

            alertDialog.show();
        }
    }

    @Override
    public boolean onMarkerClick(@NonNull @NotNull Marker marker) {
        if (!marker.getSnippet().equals("user")){
            LatLng latLng = new LatLng(marker.getPosition().latitude, marker.getPosition().longitude);
            polyline.remove();
            calculateDirections(latLng);

        } else{
            Toast.makeText(this, "Unable to find route.", Toast.LENGTH_SHORT).show();
        }

        return false;
    }
}