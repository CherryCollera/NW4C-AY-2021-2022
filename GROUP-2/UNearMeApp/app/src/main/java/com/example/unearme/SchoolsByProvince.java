package com.example.unearme;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.app.ActivityOptions;
import android.content.Intent;
import android.os.Bundle;
import android.util.Pair;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.unearme.Adapter.SchoolListAdapter;
import com.example.unearme.Helper.SchoolInfo;
import com.firebase.ui.firestore.FirestoreRecyclerOptions;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.Query;

public class SchoolsByProvince extends AppCompatActivity {
    TextView tv_province;
    RecyclerView recyclerView;
    String province;
    ImageButton back_btn;

    FirebaseFirestore firestore = FirebaseFirestore.getInstance();
    CollectionReference reference = firestore.collection("schools");
    SchoolListAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_schools_by_province);

        tv_province = findViewById(R.id.tv_province);
        recyclerView = findViewById(R.id.list_schools_by_province);
        back_btn = findViewById(R.id.back_btn);

        Intent intent = getIntent();
        province = intent.getStringExtra("province");

        tv_province.setText(province);


        recyclerView();

        adapter.setOnItemClickListener(new SchoolListAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(DocumentSnapshot documentSnapshot, int position, ImageView school_logo, TextView school_name) {

                Intent intent = new Intent(SchoolsByProvince.this, SchoolPage.class);
                intent.putExtra("school_info", documentSnapshot.toObject(SchoolInfo.class));

                Pair[] pairs = new Pair[2];
                pairs[0] = new Pair<View,String>(school_logo, "logo");
                pairs[1] = new Pair<View,String>(school_logo, "name");
                ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(SchoolsByProvince.this, pairs);
                startActivity(intent, options.toBundle());
            }
        });

        back_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                finish();

            }
        });
    }

    private void recyclerView() {
        Query query = reference.whereEqualTo("province", province).orderBy("school_name", Query.Direction.ASCENDING);
        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                .setQuery(query, SchoolInfo.class)
                .build();


        adapter = new SchoolListAdapter(options);
        recyclerView.setHasFixedSize(true);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        recyclerView.setAdapter(adapter);
    }
    @Override
    protected void onStart() {
        super.onStart();
        adapter.startListening();
    }

    @Override
    protected void onStop() {
        super.onStop();
        adapter.stopListening();
    }
}