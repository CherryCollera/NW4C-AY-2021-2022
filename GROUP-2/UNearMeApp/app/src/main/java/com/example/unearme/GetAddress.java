package com.example.unearme;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.Intent;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.Bundle;
import android.provider.Settings;
import android.view.KeyEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.webkit.PermissionRequest;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import android.net.Uri;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.tasks.OnSuccessListener;
import com.karumi.dexter.Dexter;
import com.karumi.dexter.PermissionToken;
import com.karumi.dexter.listener.PermissionDeniedResponse;
import com.karumi.dexter.listener.PermissionGrantedResponse;
import com.karumi.dexter.listener.single.PermissionListener;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class GetAddress extends AppCompatActivity implements OnMapReadyCallback {

    boolean isPermissionGranted;
    GoogleMap googleMap;

    FusedLocationProviderClient locationProviderClient;
    Location currentLocation;
    double getLatitude, getLongitude;

    EditText et_complete_address, et_search_address;
    Button add_address_btn;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_get_address);
        et_complete_address = findViewById(R.id.et_complete_address);
        et_search_address = findViewById(R.id.et_search_address);
        add_address_btn = findViewById(R.id.add_address_btn);
        add_address_btn.setOnClickListener(this::getAddress);

        locationProviderClient = LocationServices.getFusedLocationProviderClient(this);

        checkMyPermission();


        et_search_address.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
                if (actionId == EditorInfo.IME_ACTION_SEARCH){
                    searchAddress();
                }
                return false;
            }
        });
    }
    private void checkMyPermission() {
        Dexter.withContext(this).withPermission(Manifest.permission.ACCESS_FINE_LOCATION).withListener(new PermissionListener() {
            @Override
            public void onPermissionGranted(PermissionGrantedResponse permissionGrantedResponse) {
                isPermissionGranted = true;
                getCurrentLocation();
            }

            @Override
            public void onPermissionDenied(PermissionDeniedResponse permissionDeniedResponse) {
                Intent intent = new Intent();
                intent.setAction(Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
                Uri uri = Uri.fromParts("package", getPackageName(), "");
                intent.setData(uri);
                startActivity(intent);
            }

            @Override
            public void onPermissionRationaleShouldBeShown(com.karumi.dexter.listener.PermissionRequest permissionRequest, PermissionToken permissionToken) {
                permissionToken.continuePermissionRequest();
            }
        }).check();
    }
    @SuppressLint("MissingPermission")
    private void getCurrentLocation(){
        locationProviderClient.getLastLocation().addOnSuccessListener(new OnSuccessListener<Location>() {
            @Override
            public void onSuccess(Location location) {
                currentLocation = location;
                if (isPermissionGranted) {
                    SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.map_view_fragment);
                    mapFragment.getMapAsync(GetAddress.this);
                }
            }
        });
    }
    private void searchAddress() {
        String search_address = et_search_address.getText().toString();
        Geocoder geocoder = new Geocoder(GetAddress.this);
        List<Address> list = new ArrayList<>();

        try {
            list = geocoder.getFromLocationName(search_address, 1);

        } catch (IOException e) {
            Toast.makeText(this, e.toString(), Toast.LENGTH_SHORT).show();
        }
        if (list.size() > 0){
            Address address = list.get(0);
            addMarker(address.getLatitude(), address.getLongitude());
        }
    }
    private void getAddress(View view) {
        if (!validateCompleteAddress()){
            return;
        }
        String complete_address = et_complete_address.getText().toString();

            Intent intent = new Intent(GetAddress.this, Register.class);
            intent.putExtra("latitude", getLatitude);
            intent.putExtra("longitude", getLongitude);
            intent.putExtra("complete_address", complete_address);
            setResult(RESULT_OK, intent);
            finish();


    }
    private boolean validateCompleteAddress() {
        String val = et_complete_address.getText().toString();

        if (val.isEmpty()){
            et_complete_address.setError("Enter your complete address");
            et_complete_address.requestFocus();
            return false;
        } else {
            et_complete_address.setError(null);
            return true;
        }
    }



    @Override
    public void onMapReady(@NonNull GoogleMap Map) {
        googleMap = Map;
        addMarker(currentLocation.getLatitude(), currentLocation.getLongitude());

        googleMap.setOnMapClickListener(new GoogleMap.OnMapClickListener() {
            @Override
            public void onMapClick(@NonNull LatLng latLng) {
                addMarker(latLng.latitude, latLng.longitude);
                et_search_address.setText("");
            }
        });
    }

    private void addMarker(Double latitude, Double longitude){
        LatLng addMarker = new LatLng(latitude, longitude);
        MarkerOptions markerOptions = new MarkerOptions();
        markerOptions.position(addMarker);

        googleMap.clear();
        googleMap.animateCamera(CameraUpdateFactory.newLatLngZoom(addMarker, 15));
        googleMap.addMarker(markerOptions);

        getLatitude = latitude;
        getLongitude = longitude;
    }

    @Override
    protected void onStart() {
        super.onStart();
        checkMyPermission();
    }
}