package com.example.unearme;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.EventListener;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.FirebaseFirestoreException;

public class VirtualTour extends AppCompatActivity {

    private WebView virtualTour;
    FirebaseFirestore firestore;
    TextView message;
    String sid;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_virtual_tour);
        message = findViewById(R.id.message);

        Intent intent = getIntent();
        sid = intent.getStringExtra("school_id");

        firestore = FirebaseFirestore.getInstance();
        virtualTour = (WebView) findViewById(R.id.view_virtual_tour);



        getTour();

    }

    private void getTour() {
        DocumentReference reference = firestore.collection("schools").document(sid);
        reference.get().addOnSuccessListener(new OnSuccessListener<DocumentSnapshot>() {
            @SuppressLint("SetJavaScriptEnabled")
            @Override
            public void onSuccess(DocumentSnapshot snapshot) {
                if (snapshot.exists()){
                    if (snapshot.getString("tour_id") == null){
                        message.setText("No Virtual Tour Found");
                        //Toast.makeText(VirtualTour.this, "No Virtual Tour Found", Toast.LENGTH_SHORT).show();
                    } else {
                        virtualTour.setWebViewClient(new WebViewClient());
                        virtualTour.getSettings().setJavaScriptEnabled(true);
                        virtualTour.loadUrl("https://u-nearme.com/school-ad/virtual_tour/view.html?id="+snapshot.getString("tour_id"));
                        message.setVisibility(View.GONE);
                        //Toast.makeText(VirtualTour.this, "Virtual Tour Found", Toast.LENGTH_SHORT).show();
                    }
                }
            }
        });
    }
}