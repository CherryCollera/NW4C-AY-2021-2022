package com.example.unearme.Fragments;

import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.drawable.Drawable;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;
import android.net.Uri;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.example.unearme.Helper.SchoolInfo;
import com.example.unearme.MapRoute;
import com.example.unearme.Profile;
import com.example.unearme.R;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptor;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.EventListener;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.FirebaseFirestoreException;
import com.google.firebase.firestore.QuerySnapshot;

import org.jetbrains.annotations.NotNull;

import java.text.NumberFormat;
import java.util.ArrayList;
import java.util.Locale;
import java.util.Map;

public class SchoolInfoFragment extends Fragment{


    public SchoolInfoFragment() {
        // Required empty public constructor
    }

    NumberFormat nf = NumberFormat.getInstance(Locale.US);
    LinearLayout bd, md, dd;
    TextView type, entrance_exam, religious_affiliation, term_structure,school_year,
            bachelors_degree, masters_degree, doctorals_degree, requirements, address, email, website;
    Bundle bundle;
    GoogleMap mGoogleMap;
    //SchoolInfo school_info;
    FirebaseFirestore firestore;
    String sid, province;
    SupportMapFragment mapFragment;
    double school_loc_lat, school_loc_lng;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_school_info, container, false);
        initWidgets(view);
        firestore = FirebaseFirestore.getInstance();



        bundle = getArguments();
        sid = bundle.getString("school_id");


        loadSchoolInfo();
        // Displaying Info
//        type.setText(school_info.getType());
//        entrance_exam.setText(school_info.getEntrance_exam());
//        religious_affiliation.setText(school_info.getReligious_affiliation());
//        term_structure.setText(school_info.getTerm_structure());
//        school_year.setText("Starts in "+school_info.getSchool_year());

//        // Displaying Bachelor's Cost
//        if (school_info.getBachelors_cost() == 0){
//            bachelors_degree.setText("none");
//        } else {
//            bachelors_degree.setText("\u20B1 " + school_info.getBachelors_cost());
//        }
//
//        // Displaying Master's Cost
//        if (school_info.getMasters_cost() == 0){
//            masters_degree.setVisibility(View.GONE);
//            md.setVisibility(View.GONE);
//        } else {
//            masters_degree.setText("\u20B1 " + school_info.getMasters_cost());
//        }

        // Displaying Requirements
//        String r = "";
//        for (String req : school_info.getRequirements()){
//            r += "\u2022" + req + "\n";
//        }
        //requirements.setText(r);

//        // Displaying Email
//        email.setText(school_info.getEmail());
//        email.setPaintFlags(email.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
//
//        // Displaying Website
//        website.setText(school_info.getWebsite());
//        website.setPaintFlags(website.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
//
//        // Displaying Address
//        address.setText(school_info.getAddress());
        mapFragment = (SupportMapFragment) getChildFragmentManager().findFragmentById(R.id.map_view_address);
        //mapFragment.getMapAsync((OnMapReadyCallback) this);

        return view;
    }
    private void loadSchoolInfo(){

        DocumentReference documentReference = firestore.collection("schools").document(sid);
        documentReference.get().addOnSuccessListener(new OnSuccessListener<DocumentSnapshot>() {
            @Override
            public void onSuccess(DocumentSnapshot documentSnapshot) {
                if (documentSnapshot.exists()){

                    province = documentSnapshot.getString("province");

                    type.setText(documentSnapshot.getString("type"));
                    entrance_exam.setText(documentSnapshot.getString("entrance_exam"));
                    religious_affiliation.setText(documentSnapshot.getString("religious_affiliation"));
                    term_structure.setText(documentSnapshot.getString("term_structure"));
                    school_year.setText("Starts in "+documentSnapshot.getString("school_year"));

                    // Displaying Email
                    email.setText(documentSnapshot.getString("email"));
                    email.setPaintFlags(email.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);

                    // Displaying Website
                    website.setText(documentSnapshot.getString("website"));
                    website.setPaintFlags(website.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);

                    // Displaying Address
                    address.setText(documentSnapshot.getString("address"));

                    ArrayList<String> list = (ArrayList<String>) documentSnapshot.get("requirements");
                    String r = "";
                    for (String req: list){
                        r += "\u2022" + req + "\n";
                    }
                    requirements.setText(r);

                    documentReference.collection("tuition_fee").get().addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                        @Override
                        public void onComplete(@NonNull @NotNull Task<QuerySnapshot> task) {
                            if (task.isSuccessful()){
                                for (DocumentSnapshot snapshot: task.getResult()){
                                    if (snapshot.getId().equals("Bachelors Degree")){
                                        bd.setVisibility(View.VISIBLE);
                                        bachelors_degree.setText( "\u20B1"+ nf.format(snapshot.get("from")) + " - " + "\u20B1" + nf.format(snapshot.get("to")));
                                    }
                                    if (snapshot.getId().equals("Masters Degree")){
                                        md.setVisibility(View.VISIBLE);
                                        masters_degree.setText( "\u20B1"+ nf.format(snapshot.get("from")) + " - " + "\u20B1" + nf.format(snapshot.get("to")));
                                    }
                                    if (snapshot.getId().equals("Doctorals Degree")){
                                        dd.setVisibility(View.VISIBLE);
                                        doctorals_degree.setText( "\u20B1"+ nf.format(snapshot.get("from")) + " - " + "\u20B1" + nf.format(snapshot.get("to")));
                                    }
                                }
                            }
                        }
                    });

                    school_loc_lat = documentSnapshot.getGeoPoint("location").getLatitude();
                    school_loc_lng = documentSnapshot.getGeoPoint("location").getLongitude();
                    mapFragment.getMapAsync(new OnMapReadyCallback() {
                        @Override
                        public void onMapReady(@NonNull @NotNull GoogleMap googleMap) {
                            mGoogleMap = googleMap;
                            LatLng school_location = new LatLng(school_loc_lat, school_loc_lng);
                            MarkerOptions options = new MarkerOptions().position(school_location);
                            options.icon(bitmapDescriptor(getContext(), R.drawable.school));

                            mGoogleMap.addMarker(options).showInfoWindow();

                            //googleMap.clear();
                            mGoogleMap.moveCamera(CameraUpdateFactory.newLatLngZoom(school_location, 18));

                            mGoogleMap.setOnMapClickListener(new GoogleMap.OnMapClickListener() {
                                @Override
                                public void onMapClick(@NonNull @NotNull LatLng latLng) {
                                    startActivity(new Intent(getContext(), MapRoute.class).putExtra("province", province).putExtra("school_id", sid));

                                }
                            });
                        }
                    });
                } else {
                    Toast.makeText(getContext(), "Document does not exist" + sid, Toast.LENGTH_SHORT).show();
                }
            }
        }).addOnFailureListener(new OnFailureListener() {
            @Override
            public void onFailure(@NonNull @NotNull Exception e) {
                Toast.makeText(getContext(), "Error: " + e.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }



    private void initWidgets(View view) {
        bd = view.findViewById(R.id.bd);
        md = view.findViewById(R.id.md);
        dd = view.findViewById(R.id.dd);
        type = view.findViewById(R.id.type);
        entrance_exam = view.findViewById(R.id.entrance_exam);
        religious_affiliation = view.findViewById(R.id.religious_affiliation);
        term_structure = view.findViewById(R.id.term_structure);
        school_year = view.findViewById(R.id.school_year);
        bachelors_degree = view.findViewById(R.id.bachelors_degree);
        masters_degree = view.findViewById(R.id.masters_degree);
        doctorals_degree = view.findViewById(R.id.doctorals_degree);
        requirements = view.findViewById(R.id.requirements);
        address = view.findViewById(R.id.address);
        email = view.findViewById(R.id.email);
        website = view.findViewById(R.id.website);
    }
    private BitmapDescriptor bitmapDescriptor(Context context, int vectorResId){
        Drawable drawable = ContextCompat.getDrawable(context,vectorResId);
        drawable.setBounds(0,0,drawable.getIntrinsicWidth(),drawable.getIntrinsicHeight());
        Bitmap bitmap = Bitmap.createBitmap(drawable.getIntrinsicWidth(), drawable.getMinimumHeight(), Bitmap.Config.ARGB_8888);
        Canvas canvas = new Canvas(bitmap);
        drawable.draw(canvas);
        return BitmapDescriptorFactory.fromBitmap(bitmap);
    }
    private void getUserLocation() {
        FirebaseFirestore firestore = FirebaseFirestore.getInstance();
        FirebaseAuth firebaseAuth = FirebaseAuth.getInstance();
        DocumentReference documentReference = firestore.collection("students").document(firebaseAuth.getCurrentUser().getUid());
        documentReference.get().addOnCompleteListener(new OnCompleteListener<DocumentSnapshot>() {
            @Override
            public void onComplete(@NonNull @NotNull Task<DocumentSnapshot> task) {
                if (task.isSuccessful()){
                    DocumentSnapshot snapshot = task.getResult();
//                    try {
//                        // Initialize uri
//                        Uri uri = Uri.parse("https://www.google.co.in/maps/dir/" + snapshot.getGeoPoint("location").getLatitude() + "," + snapshot.getGeoPoint("location").getLongitude()
//                        + "/" + school_info.getLatitude() + "," + school_info.getLongitude());
//                        // Initialize intent with action view
//                        Intent intent = new Intent(Intent.ACTION_VIEW, uri);
//                        // Set package
//                        intent.setPackage("com.google.android.apps.maps");
//                        // Set flags
//                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
//                        // Start activity
//                        startActivity(intent);
//                    } catch (ActivityNotFoundException e){
//                        Log.d("TAG", "MAP ROUTE ERROR: " + e.getMessage());
//                    }
                    startActivity(new Intent(getContext(), MapRoute.class));


                }
            }
        });
    }
}