package com.example.unearme.Fragments;

import android.app.ActivityOptions;
import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.text.Editable;
import android.text.Layout;
import android.text.TextWatcher;
import android.util.Pair;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ScrollView;
import android.widget.TextView;

import com.example.unearme.Adapter.SchoolListAdapter;
import com.example.unearme.CPE;
import com.example.unearme.Helper.SchoolInfo;
import com.example.unearme.Profile;
import com.example.unearme.R;
import com.example.unearme.SchoolPage;
import com.example.unearme.SchoolsByProvince;
import com.firebase.ui.firestore.FirestoreRecyclerAdapter;
import com.firebase.ui.firestore.FirestoreRecyclerOptions;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.Query;
import com.squareup.picasso.Picasso;

import org.jetbrains.annotations.NotNull;

public class HomeFragment extends Fragment {

    public HomeFragment() {
        // Required empty public constructor
    }

    TextView aurora_schools, bataan_schools, bulacan_schools, nueva_ecija_schools, pampanga_schools, tarlac_schools, zambales_schools;
    EditText et_search;
    RecyclerView recyclerView, recently_added;
    Button btncpe;
    LinearLayout scrollView;
    FirestoreRecyclerAdapter add;
    FirebaseFirestore firestore = FirebaseFirestore.getInstance();
    CollectionReference reference = firestore.collection("schools");
    CollectionReference test = firestore.collection("test");
    private SchoolListAdapter adapter;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_home, container, false);

        // Widgets
        initWidgets(view);

        // TextView on Clicks
//        aurora_schools.setOnClickListener(this::auroraSchools);
//        bataan_schools.setOnClickListener(this::bataanSchools);
//        bulacan_schools.setOnClickListener(this::bulacanSchools);
//        nueva_ecija_schools.setOnClickListener(this::nuevaecijaSchools);
//        pampanga_schools.setOnClickListener(this::pampangaSchools);
//        tarlac_schools.setOnClickListener(this::tarlacSchools);
//        zambales_schools.setOnClickListener(this::zambalesSchools);
        recentlyAdded();
        recyclerView();

        btncpe.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent a = new Intent(getContext(), CPE.class);
                startActivity(a);
            }
        });

        et_search.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) { }
            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) { }
            @Override
            public void afterTextChanged(Editable s) {
                if (s.toString().isEmpty()){
                    recyclerView.setVisibility(View.GONE);
                    scrollView.setVisibility(View.VISIBLE);
                } else {
                    recyclerView.setVisibility(View.VISIBLE);
                    scrollView.setVisibility(View.GONE);
                    filter(s.toString());
                }
            }
        });

        return view;
    }

    private void recentlyAdded() {
        Query query = reference.orderBy("date_added", Query.Direction.DESCENDING).limit(5);
        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                .setQuery(query, SchoolInfo.class)
                .build();

        add = new FirestoreRecyclerAdapter<SchoolInfo, SchoolListHolder>(options) {
            @NonNull
            @NotNull
            @Override
            public SchoolListHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
                View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.recently_added, parent, false);
                return new SchoolListHolder(view);
            }

            @Override
            protected void onBindViewHolder(@NonNull @NotNull HomeFragment.SchoolListHolder holder, int position, @NonNull @NotNull SchoolInfo model) {
                holder.textView.setText(model.getSchool_id());
                Picasso.get()
                        .load(model.getSchool_logo())
                        .placeholder(R.drawable.placeholder_img)
                        .fit()
                        .centerInside()
                        .into(holder.imageView);
            }
        };

        recently_added.setHasFixedSize(true);
        recently_added.setLayoutManager(new LinearLayoutManager(getContext(), RecyclerView.HORIZONTAL, false));
        recently_added.setAdapter(add);



    }

    private class SchoolListHolder extends RecyclerView.ViewHolder{

        private TextView textView;
        private ImageView imageView;

        public SchoolListHolder(@NonNull @NotNull View itemView) {
            super(itemView);
            textView = itemView.findViewById(R.id.ssschool_id);
            imageView = itemView.findViewById(R.id.ssschool_logo);

            itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                    startActivity(new Intent(getContext(), SchoolPage.class)
                    .putExtra("school_id", textView.getText()));

                }
            });


        }
    }

    private void recyclerView() {
        Query query = reference.orderBy("school_name", Query.Direction.ASCENDING);
        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                .setQuery(query, SchoolInfo.class)
                .build();

        adapter = new SchoolListAdapter(options);
        recyclerView.setHasFixedSize(true);
        recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
        recyclerView.setAdapter(adapter);

        adapter.setOnItemClickListener(new SchoolListAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(DocumentSnapshot documentSnapshot, int position, ImageView school_logo, TextView school_name) {
                Intent intent = new Intent(getContext(), SchoolPage.class);
                //intent.putExtra("school_info", documentSnapshot.toObject(SchoolInfo.class));
                intent.putExtra("school_id", documentSnapshot.getId());
                Pair[] pairs = new Pair[2];
                pairs[0] = new Pair<View,String>(school_logo, "logo");
                pairs[1] = new Pair<View,String>(school_name, "name");
                ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(getActivity(), pairs);
                startActivity(intent, options.toBundle());
            }
        });
    }
    private void filter(String text){
        Query query = reference.orderBy("school_name").startAt(text).endAt(text + "\uf8ff");
        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                .setQuery(query, SchoolInfo.class)
                .build();
        adapter.updateOptions(options);
    }

    private void auroraSchools(View view) {
        startActivity(new Intent(getContext(), SchoolsByProvince.class).putExtra("province", "Aurora"));
    }
    private void bataanSchools(View view) {
        startActivity(new Intent(getContext(), SchoolsByProvince.class).putExtra("province", "Bataan"));
    }
    private void bulacanSchools(View view) {
        startActivity(new Intent(getContext(), SchoolsByProvince.class).putExtra("province", "Bulacan"));
    }
    private void nuevaecijaSchools(View view) {
        startActivity(new Intent(getContext(), SchoolsByProvince.class).putExtra("province", "Nueva Ecija"));
    }
    private void pampangaSchools(View view) {
        startActivity(new Intent(getContext(), SchoolsByProvince.class).putExtra("province", "Pampanga"));
    }
    private void tarlacSchools(View view) {
        startActivity(new Intent(getContext(), SchoolsByProvince.class).putExtra("province", "Tarlac"));
    }
    private void zambalesSchools(View view) {
        startActivity(new Intent(getContext(), SchoolsByProvince.class).putExtra("province", "Zambales"));
    }

    @Override
    public void onStart() {
        super.onStart();
        add.startListening();
        adapter.startListening();

    }

    @Override
    public void onResume() {
        super.onResume();
        add.startListening();
        adapter.startListening();
    }

    @Override
    public void onStop() {
        super.onStop();
        add.stopListening();
        adapter.stopListening();


    }

    private void initWidgets(View view){
        et_search = view.findViewById(R.id.et_search);
//        aurora_schools = view.findViewById(R.id.aurora_schools);
//        bataan_schools = view.findViewById(R.id.bataan_schools);
//        bulacan_schools = view.findViewById(R.id.bulacan_schools);
//        nueva_ecija_schools = view.findViewById(R.id.nueva_ecija_schools);
//        pampanga_schools = view.findViewById(R.id.pampanga_schools);
//        tarlac_schools = view.findViewById(R.id.tarlac_schools);
//        zambales_schools = view.findViewById(R.id.zambales_schools);
        recyclerView = view.findViewById(R.id.all_schools);
        recently_added = view.findViewById(R.id.rrrecently_added);
        scrollView = view.findViewById(R.id.scrollable);
        btncpe = view.findViewById(R.id.cpe);
    }

}