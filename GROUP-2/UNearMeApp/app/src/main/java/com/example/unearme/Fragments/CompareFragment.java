package com.example.unearme.Fragments;

import android.app.Dialog;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.example.unearme.Adapter.SchoolListAdapter;
import com.example.unearme.Helper.SchoolInfo;
import com.example.unearme.R;
import com.example.unearme.SchoolPage;
import com.firebase.ui.firestore.FirestoreRecyclerOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.Query;
import com.google.firebase.firestore.QuerySnapshot;
import com.squareup.picasso.Picasso;

import org.jetbrains.annotations.NotNull;

import java.text.NumberFormat;
import java.util.ArrayList;
import java.util.Locale;

import static android.graphics.Color.TRANSPARENT;


public class CompareFragment extends Fragment {

    public CompareFragment() {
        // Required empty public constructor
    }

    LinearLayout linearlayout1, linearlayout2, ll1, ll2, abd, amd, add, bbd, bmd, bdd;
    ImageButton addSchoolA, addSchoolB, removeSchoolA, removeSchoolB;

    NumberFormat nf = NumberFormat.getInstance(Locale.US);
    private final FirebaseFirestore firestore = FirebaseFirestore.getInstance();
    private final CollectionReference reference = firestore.collection("schools");
    Dialog dialog;
    private SchoolListAdapter adapter;
    String p = "";
    String school;
    RecyclerView recyclerView;
    EditText search_school;
    ImageView school_a_logo, school_b_logo;
    String school_a_id, school_b_id;
    TextView school_a_name, school_a_type, school_a_address, school_a_ee, school_a_ts, school_a_sy, school_a_ra, school_a_programs, abachelors_degree, amasters_degree, adoctorals_degree;
    TextView school_b_name, school_b_type, school_b_address, school_b_ee, school_b_ts, school_b_sy, school_b_ra, school_b_programs, bbachelors_degree, bmasters_degree, bdoctorals_degree;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_compare, container, false);
        initWidgets(view);
        dataBase();



        addSchoolA.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                school = "a";
                addSchool(school);
            }
        });
        addSchoolB.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                school = "b";
                addSchool(school);
            }
        });

        removeSchoolA.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                linearlayout1.setVisibility(View.INVISIBLE);
                ll1.setVisibility(View.VISIBLE);
            }
        });

        removeSchoolB.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                linearlayout2.setVisibility(View.INVISIBLE);
                ll2.setVisibility(View.VISIBLE);
            }
        });

        school_a_logo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), SchoolPage.class).putExtra("school_id", school_a_id));
            }
        });
        school_b_logo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), SchoolPage.class).putExtra("school_id", school_b_id));
            }
        });

        return view;
    }



    private void addSchool(String school) {
        dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.dialog_select_school);
        dialog.getWindow().setLayout(1000, 1500);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(TRANSPARENT));
        dialog.show();

        recyclerView = dialog.findViewById(R.id.compareSchool);
        search_school = dialog.findViewById(R.id.search_school);

        search_school.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {

            }

            @Override
            public void afterTextChanged(Editable s) {
                filter(s.toString());
            }
        });

        recyclerView.setHasFixedSize(true);
        recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
        recyclerView.setAdapter(adapter);

        if (school.equals("a")) {
            adapter.setOnItemClickListener(new SchoolListAdapter.OnItemClickListener() {
                @Override
                public void onItemClick(DocumentSnapshot documentSnapshot, int position, ImageView school_logo, TextView school_name) {
                    linearlayout1.setVisibility(View.VISIBLE);
                    ll1.setVisibility(View.INVISIBLE);
                    dialog.dismiss();
                    school_a_id = documentSnapshot.getId();
                    SchoolInfo school_info = documentSnapshot.toObject(SchoolInfo.class);
                    Picasso.get()
                            .load(school_info.getSchool_logo())
                            .placeholder(R.drawable.placeholder_img)
                            .fit()
                            .centerInside()
                            .into(school_a_logo);
                    school_a_name.setText(school_info.getSchool_name());
                    school_a_type.setText(school_info.getType());
                    school_a_ee.setText(school_info.getEntrance_exam());
                    school_a_ts.setText(school_info.getTerm_structure());
                    school_a_sy.setText(school_info.getSchool_year());
                    school_a_ra.setText(school_info.getReligious_affiliation());
                    String programs = "";
                    for (String p : school_info.getPrograms()){
                        programs += "\u2022" + p + "\n";
                    }
                    school_a_programs.setText(programs);

                    reference.document(documentSnapshot.getId()).collection("tuition_fee").get().addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                        @Override
                        public void onComplete(@NonNull @NotNull Task<QuerySnapshot> task) {
                            if (task.isSuccessful()){
                                for (DocumentSnapshot snapshot: task.getResult()){
                                    if (snapshot.getId().equals("Bachelors Degree")){
                                        abd.setVisibility(View.VISIBLE);
                                        abachelors_degree.setText( "\u20B1"+ nf.format(snapshot.get("from")) + " - " + "\u20B1" + nf.format(snapshot.get("to")));
                                    }
                                    if (snapshot.getId().equals("Masters Degree")){
                                        amd.setVisibility(View.VISIBLE);
                                        amasters_degree.setText( "\u20B1"+  nf.format(snapshot.get("from")) + " - " + "\u20B1" + nf.format(snapshot.get("to")));
                                    }
                                    if (snapshot.getId().equals("Doctorals Degree")){
                                        add.setVisibility(View.VISIBLE);
                                        adoctorals_degree.setText( "\u20B1"+  nf.format(snapshot.get("from")) + " - " + "\u20B1" +nf.format(snapshot.get("to")));
                                    }
                                }
                            }
                        }
                    });
                    school_a_address.setText(school_info.getAddress());
                }
            });
        }
        else if (school.equals("b")) {
            adapter.setOnItemClickListener(new SchoolListAdapter.OnItemClickListener() {
                @Override
                public void onItemClick(DocumentSnapshot documentSnapshot, int position, ImageView school_logo, TextView school_name) {
                    linearlayout2.setVisibility(View.VISIBLE);
                    ll2.setVisibility(View.INVISIBLE);
                    dialog.dismiss();
                    school_b_id = documentSnapshot.getId();
                    SchoolInfo school_info = documentSnapshot.toObject(SchoolInfo.class);
                    Picasso.get()
                            .load(school_info.getSchool_logo())
                            .placeholder(R.drawable.placeholder_img)
                            .fit()
                            .centerInside()
                            .into(school_b_logo);
                    school_b_name.setText(school_info.getSchool_name());
                    school_b_type.setText(school_info.getType());
                    school_b_ee.setText(school_info.getEntrance_exam());
                    school_b_ts.setText(school_info.getTerm_structure());
                    school_b_sy.setText(school_info.getSchool_year());
                    school_b_ra.setText(school_info.getReligious_affiliation());
                    String programs = "";
                    for (String p : school_info.getPrograms()){
                        programs += "\u2022" + p + "\n";
                    }
                    school_b_programs.setText(programs);

                    reference.document(documentSnapshot.getId()).collection("tuition_fee").get().addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                        @Override
                        public void onComplete(@NonNull @NotNull Task<QuerySnapshot> task) {
                            if (task.isSuccessful()){
                                for (DocumentSnapshot snapshot: task.getResult()){
                                    if (snapshot.getId().equals("Bachelors Degree")){
                                        bbd.setVisibility(View.VISIBLE);
                                        bbachelors_degree.setText( "\u20B1"+  nf.format(snapshot.get("from")) + " - " + "\u20B1" + nf.format(snapshot.get("to")));

                                    }
                                    if (snapshot.getId().equals("Masters Degree")){
                                        bmd.setVisibility(View.VISIBLE);
                                        bmasters_degree.setText( "\u20B1"+  nf.format(snapshot.get("from")) + " - " + "\u20B1" + nf.format(snapshot.get("to")));
                                    }
                                    if (snapshot.getId().equals("Doctorals Degree")){
                                        bdd.setVisibility(View.VISIBLE);
                                        bdoctorals_degree.setText( "\u20B1"+ nf.format(snapshot.get("from")) + " - " + "\u20B1" + nf.format(snapshot.get("to")));
                                    }
                                }
                            }
                        }
                    });
                    school_b_address.setText(school_info.getAddress());
                }
            });
        }

    }

    private void dataBase() {
        Query query = reference.orderBy("school_name", Query.Direction.ASCENDING);
        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                .setQuery(query, SchoolInfo.class)
                .build();

        adapter = new SchoolListAdapter(options);
    }

    private void filter(String text) {

        Query query = reference.orderBy("school_name").startAt(text).endAt(text + "\uf8ff");
        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                .setQuery(query, SchoolInfo.class)
                .build();
        adapter.updateOptions(options);
    }

    @Override
    public void onStart() {
        super.onStart();
        adapter.startListening();
    }

    @Override
    public void onStop() {
        super.onStop();
        adapter.stopListening();
    }

    private void initWidgets(View view) {
        linearlayout1 = view.findViewById(R.id.linearLayout1);
        linearlayout2 = view.findViewById(R.id.linearLayout2);
        ll1 = view.findViewById(R.id.ll1);
        ll2 = view.findViewById(R.id.ll2);

        addSchoolA = view.findViewById(R.id.addSchoolA);
        addSchoolB = view.findViewById(R.id.addSchoolB);
        removeSchoolA = view.findViewById(R.id.removeSchoolA);
        removeSchoolB = view.findViewById(R.id.removeSchoolB);
        school_a_logo = view.findViewById(R.id.school_a_logo);
        school_a_name = view.findViewById(R.id.school_a_name);
        school_a_type = view.findViewById(R.id.school_a_type);
        school_a_address = view.findViewById(R.id.school_a_address);
        school_a_ee = view.findViewById(R.id.school_a_entrance);
        school_a_ts = view.findViewById(R.id.school_a_term_structure);
        school_a_sy = view.findViewById(R.id.school_a_school_year);
        school_a_ra = view.findViewById(R.id.school_a_religion_affiliation);
        school_a_programs = view.findViewById(R.id.school_a_programs);
        school_b_programs = view.findViewById(R.id.school_b_programs);
        school_b_logo = view.findViewById(R.id.school_b_logo);
        school_b_name = view.findViewById(R.id.school_b_name);
        school_b_type = view.findViewById(R.id.school_b_type);
        school_b_address = view.findViewById(R.id.school_b_address);
        school_b_ee = view.findViewById(R.id.school_b_entrance);
        school_b_ts = view.findViewById(R.id.school_b_term_structure);
        school_b_sy = view.findViewById(R.id.school_b_school_year);
        school_b_ra = view.findViewById(R.id.school_b_religion_affiliation);

        abd =  view.findViewById(R.id.abd);
        abachelors_degree = view.findViewById(R.id.abachelors_degree);
        amasters_degree = view.findViewById(R.id.amasters_degree);
        adoctorals_degree = view.findViewById(R.id.adoctorals_degree);
        amd = view.findViewById(R.id.amd);
        add = view.findViewById(R.id.add);

        bbd =  view.findViewById(R.id.bbd);
        bbachelors_degree = view.findViewById(R.id.bbachelors_degree);
        bmasters_degree = view.findViewById(R.id.bmasters_degree);
        bdoctorals_degree = view.findViewById(R.id.bdoctorals_degree);
        bmd = view.findViewById(R.id.bmd);
        bdd = view.findViewById(R.id.bdd);
    }
}