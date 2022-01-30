package com.example.unearme.Fragments;

import android.app.ActivityOptions;
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
import android.util.Pair;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.daimajia.androidanimations.library.Techniques;
import com.daimajia.androidanimations.library.YoYo;
import com.example.unearme.Adapter.SchoolListAdapter;
import com.example.unearme.Adapter.SchoolListSearchAdapter;
import com.example.unearme.Helper.SchoolInfo;
import com.example.unearme.R;
import com.example.unearme.SchoolPage;
import com.firebase.ui.firestore.FirestoreRecyclerOptions;
import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.Query;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;

import org.jetbrains.annotations.NotNull;

import java.text.NumberFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Locale;

import static android.graphics.Color.TRANSPARENT;

public class SearchFragment extends Fragment {


    public SearchFragment() {
        // Required empty public constructor
    }

    RelativeLayout filtered_list;
    LinearLayout filter_search, filter_search_container, haha;
    ImageButton close_filtered_list;
    EditText search_programs, search_province, search_degree, search_cost_to;
    TextView filtered_province, filtered_program, filtered_degree, filtered_costs, no_school_found;
    ArrayList<String> arrayListPrograms, arrayListProvince, arrayListDegree, arrayListCosts;
    Dialog dialog;
    Button filter_search_btn;
    RecyclerView filteredRecyclerView;
    private SchoolListSearchAdapter adapter;
    private FirebaseFirestore firestore = FirebaseFirestore.getInstance();
    private CollectionReference reference = firestore.collection("schools");

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_search, container, false);
        initWidgets(view);
        recylerView();


        // adding string array (programs) from  strings.xml to arraylist
        arrayListPrograms = new ArrayList<>();
        arrayListPrograms.addAll(Arrays.asList(getResources().getStringArray(R.array.programs)));

        // adding string array (province) from  strings.xml to arraylist
        arrayListProvince = new ArrayList<>();
        arrayListProvince.addAll(Arrays.asList(getResources().getStringArray(R.array.province)));

        arrayListDegree = new ArrayList<>();
        arrayListDegree.addAll(Arrays.asList(getResources().getStringArray(R.array.degree)));

        arrayListCosts = new ArrayList<>();
        arrayListCosts.addAll(Arrays.asList(getResources().getStringArray(R.array.costs)));

        adapter.setOnItemClickListener(new SchoolListSearchAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(DocumentSnapshot documentSnapshot, int position, ImageView school_logo, TextView school_name) {

                Intent intent = new Intent(getContext(), SchoolPage.class);
//                intent.putExtra("school_info", documentSnapshot.toObject(SchoolInfo.class));
                intent.putExtra("school_id", documentSnapshot.getId());

                Pair[] pairs = new Pair[2];
                pairs[0] = new Pair<View,String>(school_logo, "logo");
                pairs[1] = new Pair<View,String>(school_logo, "name");
                ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(getActivity(), pairs);
                startActivity(intent, options.toBundle());
            }
        });

        search_programs.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                openDialogPrograms();
            }
        });

        search_province.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                openDialogProvince();
            }
        });

        search_degree.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                openDialogDegree();
            }
        });


        search_cost_to.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                openDialogCostTo();
            }
        });

        filter_search_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                filterSearch();
            }
        });

        close_filtered_list.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                clearFilterSearch();

                YoYo.with(Techniques.SlideOutDown)
                        .duration(500)
                        .playOn(filtered_list);
                YoYo.with(Techniques.SlideInUp)
                        .duration(500)
                        .playOn(filter_search);


            }
        });

        return view;
    }

    private void clearFilterSearch() {
        search_programs.setText("");
        search_province.setText("");
        search_degree.setText("");
        search_cost_to.setText("");
    }

    private void filterSearch() {
        String program = search_programs.getText().toString();
        String province = search_province.getText().toString();
        String degree = search_degree.getText().toString();
        String cost_to = search_cost_to.getText().toString();

        if (province.isEmpty() || degree.isEmpty() || cost_to.isEmpty()) {
            Toast.makeText(getContext(), "Some information is/are missing", Toast.LENGTH_SHORT).show();
            return;
        }
        else {

            filtered_list.setVisibility(View.VISIBLE);
            YoYo.with(Techniques.SlideInUp)
                    .duration(500)
                    .playOn(filtered_list);
            YoYo.with(Techniques.SlideOutDown)
                    .duration(500)
                    .playOn(filter_search);

            filtered_program.setText(program);
            filtered_province.setText(province);
            filtered_degree.setText(degree);
            filtered_costs.setText(cost_to);

            cost_to = cost_to.replaceAll("[^\\d.]", "");
            if (cost_to.isEmpty()){
                cost_to = "0";
            }

            if (Integer.parseInt(cost_to)==100001){
                if (degree.equals("Bachelors Degree")) {
                    if (program.isEmpty()){
                        haha.setVisibility(View.GONE);
//                    filtered_province.setVisibility(View.GONE);
                        Query query = reference
                                .orderBy("bachelors_cost")
                                .orderBy("school_name")
                                .whereEqualTo("province", province)
                                .whereGreaterThanOrEqualTo("bachelors_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);

                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }

                    } else {
                        haha.setVisibility(View.VISIBLE);
                        Query query = reference
                                .orderBy("bachelors_cost").orderBy("school_name")
                                .whereArrayContains("programs", program)
                                .whereEqualTo("province", province)
                                .whereGreaterThanOrEqualTo("bachelors_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }
                    }
                }
                if (degree.equals("Masters Degree")) {


                    if (program.isEmpty()){
                        haha.setVisibility(View.GONE);
                        Query query = reference
                                .orderBy("masters_cost")
                                .orderBy("school_name")
                                .whereEqualTo("province", province)
                                .whereGreaterThanOrEqualTo("masters_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }

                    } else {
                        haha.setVisibility(View.VISIBLE);
                        Query query = reference
                                .orderBy("masters_cost").orderBy("school_name")
                                .whereArrayContains("programs", program)
                                .whereEqualTo("province", province)
                                .whereGreaterThanOrEqualTo("masters_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }
                    }
                }
                if (degree.equals("Doctorals Degree")) {


                    if (program.isEmpty()){
                        haha.setVisibility(View.GONE);
                        Query query = reference
                                .orderBy("doctorals_cost")
                                .orderBy("school_name")
                                .whereEqualTo("province", province)
                                .whereGreaterThanOrEqualTo("doctorals_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }

                    } else {
                        haha.setVisibility(View.VISIBLE);
                        Query query = reference
                                .orderBy("doctorals_cost").orderBy("school_name")
                                .whereArrayContains("programs", program)
                                .whereEqualTo("province", province)
                                .whereGreaterThanOrEqualTo("doctorals_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }
                    }
                }
            } else {
                if (degree.equals("Bachelors Degree")) {
                    if (program.isEmpty()){
                        haha.setVisibility(View.GONE);
//                    filtered_province.setVisibility(View.GONE);
                        Query query = reference
                                .orderBy("bachelors_cost")
                                .orderBy("school_name")
                                .whereEqualTo("province", province)
                                .whereLessThanOrEqualTo("bachelors_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);

                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }

                    } else {
                        haha.setVisibility(View.VISIBLE);
                        Query query = reference
                                .orderBy("bachelors_cost").orderBy("school_name")
                                .whereArrayContains("programs", program)
                                .whereEqualTo("province", province)
                                .whereLessThanOrEqualTo("bachelors_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }
                    }
                }
                if (degree.equals("Masters Degree")) {


                    if (program.isEmpty()){
                        haha.setVisibility(View.GONE);
                        Query query = reference
                                .orderBy("masters_cost")
                                .orderBy("school_name")
                                .whereEqualTo("province", province)
                                .whereLessThanOrEqualTo("masters_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }

                    } else {
                        haha.setVisibility(View.VISIBLE);
                        Query query = reference
                                .orderBy("masters_cost").orderBy("school_name")
                                .whereArrayContains("programs", program)
                                .whereEqualTo("province", province)
                                .whereLessThanOrEqualTo("masters_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }
                    }
                }
                if (degree.equals("Doctorals Degree")) {


                    if (program.isEmpty()){
                        haha.setVisibility(View.GONE);
                        Query query = reference
                                .orderBy("doctorals_cost")
                                .orderBy("school_name")
                                .whereEqualTo("province", province)
                                .whereLessThanOrEqualTo("doctorals_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }

                    } else {
                        haha.setVisibility(View.VISIBLE);
                        Query query = reference
                                .orderBy("doctorals_cost").orderBy("school_name")
                                .whereArrayContains("programs", program)
                                .whereEqualTo("province", province)
                                .whereLessThanOrEqualTo("doctorals_cost", Integer.parseInt(cost_to));

                        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                                .setQuery(query, SchoolInfo.class)
                                .build();
                        adapter.updateOptions(options);
                        if (adapter.getItemCount() == 0){
                            no_school_found.setVisibility(View.VISIBLE);
                        }
                    }
                }

            }
        }
    }

    private void recylerView() {
        Query query = reference.orderBy("school_name", Query.Direction.ASCENDING);
        FirestoreRecyclerOptions<SchoolInfo> options = new FirestoreRecyclerOptions.Builder<SchoolInfo>()
                .setQuery(query, SchoolInfo.class)
                .build();
        adapter = new SchoolListSearchAdapter(options);
        filteredRecyclerView.setHasFixedSize(true);
        filteredRecyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
        filteredRecyclerView.setAdapter(adapter);
    }

    private void openDialogCostTo() {
        dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.dialog_select);
        dialog.getWindow().setLayout(1000, 800);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(TRANSPARENT));
        dialog.show();

        TextView title = dialog.findViewById(R.id.title);
        title.setText("Tuition Fee");
        ListView list_view_province = dialog.findViewById(R.id.list_view_province);

        ArrayAdapter<String> adapter = new ArrayAdapter<>(getContext(), android.R.layout.simple_list_item_1, arrayListCosts);
        list_view_province.setAdapter(adapter);


        list_view_province.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                search_cost_to.setText(adapter.getItem(position));
                dialog.dismiss();
            }
        });
    }
    private void openDialogDegree() {
        dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.dialog_select);
        dialog.getWindow().setLayout(1000, 605);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(TRANSPARENT));
        dialog.show();

        TextView title = dialog.findViewById(R.id.title);
        title.setText("Select Degree");
        ListView list_view_province = dialog.findViewById(R.id.list_view_province);

        ArrayAdapter<String> adapter = new ArrayAdapter<>(getContext(), android.R.layout.simple_list_item_1, arrayListDegree);
        list_view_province.setAdapter(adapter);


        list_view_province.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                search_degree.setText(adapter.getItem(position));
                dialog.dismiss();
            }
        });
    }
    private void openDialogProvince() {
        dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.dialog_select);
        dialog.getWindow().setLayout(1000, 800);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(TRANSPARENT));
        dialog.show();

        TextView title = dialog.findViewById(R.id.title);
        title.setText("Select Province");
        ListView list_view_province = dialog.findViewById(R.id.list_view_province);

        ArrayAdapter<String> adapter = new ArrayAdapter<>(getContext(), android.R.layout.simple_list_item_1, arrayListProvince);
        list_view_province.setAdapter(adapter);


        list_view_province.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                search_province.setText(adapter.getItem(position));
                dialog.dismiss();
            }
        });
    }
    private void openDialogPrograms() {
        dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.dialog_search_programs);
        dialog.getWindow().setLayout(1000, 1500);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(TRANSPARENT));
        dialog.show();


        EditText search_edit_text = dialog.findViewById(R.id.search_edit_text);
        ListView list_view_programs = dialog.findViewById(R.id.list_view_programs);

        ArrayAdapter<String> adapter = new ArrayAdapter<>(getContext(), android.R.layout.simple_list_item_1, arrayListPrograms);
        list_view_programs.setAdapter(adapter);

        search_edit_text.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                adapter.getFilter().filter(s);
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });

        list_view_programs.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                search_programs.setText(adapter.getItem(position));
                dialog.dismiss();
            }
        });
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
        no_school_found = view.findViewById(R.id.no_school_found);
        filtered_list = view.findViewById(R.id.filtered_list);
        filter_search = view.findViewById(R.id.filter_search);
//        filter_search_container = view.findViewById(R.id.filtered_school_container);
        close_filtered_list = view.findViewById(R.id.close_filtered_list);
        filter_search_btn = view.findViewById(R.id.filter_search_btn);
        search_programs = view.findViewById(R.id.search_programs);
        search_province = view.findViewById(R.id.search_province);
        search_degree = view.findViewById(R.id.search_degree);

        search_cost_to = view.findViewById(R.id.search_cost_to);
        filteredRecyclerView = view.findViewById(R.id.filteredRecyclerView);

        filtered_province = view.findViewById(R.id.filtered_province);
        filtered_program = view.findViewById(R.id.filtered_program);
        filtered_degree = view.findViewById(R.id.filtered_degree);
        filtered_costs = view.findViewById(R.id.filtered_costs);

        haha = view.findViewById(R.id.haha);
    }
}