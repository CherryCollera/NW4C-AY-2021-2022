package com.example.unearme.Fragments;

import android.net.Uri;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.example.unearme.Helper.SchoolInfo;
import com.example.unearme.R;
import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.EventListener;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.FirebaseFirestoreException;
import com.google.firebase.firestore.QuerySnapshot;

import org.jetbrains.annotations.NotNull;

import java.util.ArrayList;
import java.util.Collection;
import java.util.Collections;
import java.util.Objects;

public class SchoolProgramsFragment extends Fragment {

    public SchoolProgramsFragment() {
        // Required empty public constructor
    }

    FirebaseFirestore firestore;
    Bundle bundle;
    String sid;
    TextView programs;
    String p = "";


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_school_programs, container, false);

        programs = view.findViewById(R.id.programs);
//
        firestore = FirebaseFirestore.getInstance();
        bundle = getArguments();
        sid = bundle.getString("school_id");



        loadPrograms();


//
//        // Sort Programs A-Z
//        Collections.sort(school_info.getPrograms());
//
//        // Displaying Programs
//        String p = "";
//        for (String programs : school_info.getPrograms()){
//            p += programs + "\n\n";
//        }
//
//        programs.setText(p);

        return view;
    }

    private void loadPrograms(){
        DocumentReference reference = firestore.collection("schools").document(sid);
        reference.get().addOnSuccessListener(new OnSuccessListener<DocumentSnapshot>() {
            @Override
            public void onSuccess(DocumentSnapshot snapshot) {
                //Displaying Programs
                ArrayList<String> list = (ArrayList<String>) snapshot.get("programs");
                for (String programs : list){
                    p +=  "\t\u2022 " + programs + "\n\n";
                }

                programs.setText(p);

            }
        }).addOnFailureListener(new OnFailureListener() {
            @Override
            public void onFailure(@NonNull @NotNull Exception e) {
                Toast.makeText(getContext(), e.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }
}