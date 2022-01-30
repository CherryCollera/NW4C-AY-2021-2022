package com.example.unearme.Fragments;

import android.app.ProgressDialog;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.unearme.Helper.Feedback;
import com.example.unearme.R;
import com.firebase.ui.firestore.FirestoreRecyclerAdapter;
import com.firebase.ui.firestore.FirestoreRecyclerOptions;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.CollectionReference;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.EventListener;
import com.google.firebase.firestore.FieldValue;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.FirebaseFirestoreException;
import com.google.firebase.firestore.Query;
import com.google.firebase.firestore.QuerySnapshot;

import org.jetbrains.annotations.NotNull;

import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.regex.Pattern;

public class SchoolFeedbackFragment extends Fragment {


    public SchoolFeedbackFragment() {
        // Required empty public constructor
    }

    RecyclerView feedbacksRecyclerView;
    TextView school_name;
    Button add_feedback;
    FirebaseFirestore firestore;
    FirebaseAuth firebaseAuth;
    FirestoreRecyclerAdapter adapter;
    String fullName, feedback, sid;
    Bundle bundle;
    ProgressDialog progressDialog;
    Boolean show_name = false;
    String checkedWords = "";
    List<String> words = Arrays.asList("tanga", "bobo", "pota", "puta", "obob", "gago", "ogag", "tangna",
            "tang na", "tangina", "tang ina", "inamo", "ina mo", "siraulo", "sira ulo", "b0b0", "0b0b", "tnga", "fuck", "fuck you", "fuckyou", "fvck",
            "pakyu", "bullshit", "shit", "damn", "piss off", "dick", "ass", "asshole", "bitch", "bastard", "suck", "pussy", "sex", "hayop", "potang ina", "putang ina", "potangina", "putangina", "tae");

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_school_virtual, container, false);
        progressDialog();

        feedbacksRecyclerView = view.findViewById(R.id.feedbacksRecyclerView);
        school_name = view.findViewById(R.id.school_name);
        add_feedback = view.findViewById(R.id.add_feedback);

        firebaseAuth = FirebaseAuth.getInstance();
        firestore = FirebaseFirestore.getInstance();

        bundle = getArguments();
        sid = bundle.getString("school_id");

        loadUserInfo();
        checkUserFeedback();
        loadFeedbacks();

        add_feedback.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showFeedbackDialog();
            }
        });

        return view;
    }
    private void showFeedbackDialog() {
        final AlertDialog.Builder builder = new AlertDialog.Builder(getContext());
        View view = getLayoutInflater().inflate(R.layout.add_feedback_dialog, null);

        CheckBox display_name = view.findViewById(R.id.display_name);
        EditText input_feedback = view.findViewById(R.id.input_feedback);
        Button send_feedback = view.findViewById(R.id.send_feedback);
        //Button reset_no = view.findViewById(R.id.reset_no);

        builder.setView(view);
        final AlertDialog alertDialog = builder.create();
        alertDialog.getWindow().setBackgroundDrawableResource(R.color.transparent);

        send_feedback.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                feedback = input_feedback.getText().toString();
                if (feedback.isEmpty()){
                    input_feedback.setError("Enter a feedback");
                } else {
                    progressDialog.show();
                    if (display_name.isChecked()){
                        show_name = true;
                    }
                    addFeedback();
                    alertDialog.dismiss();
                }
            }
        });

        alertDialog.show();
    }
    private void addFeedback(){
            Map<String, Object> feedback_info = new HashMap<>();
            feedback_info.put("user_name", fullName);
            feedback_info.put("display_name", show_name);
            feedback_info.put("feedback", feedback);
            feedback_info.put("user_id", firebaseAuth.getCurrentUser().getUid());
            feedback_info.put("time", FieldValue.serverTimestamp());
            firestore.collection("schools").document(sid)
                    .collection("feedbacks").add(feedback_info)
                    .addOnSuccessListener(new OnSuccessListener<DocumentReference>() {
                        @Override
                        public void onSuccess(DocumentReference documentReference) {
                            progressDialog.dismiss();
                            add_feedback.setVisibility(View.GONE);
                        }
                    });

    }
    private void loadUserInfo(){
        DocumentReference documentReference = firestore.collection("students").document(firebaseAuth.getCurrentUser().getUid());
        documentReference.addSnapshotListener(new EventListener<DocumentSnapshot>() {
            @Override
            public void onEvent(@Nullable @org.jetbrains.annotations.Nullable DocumentSnapshot value, @Nullable @org.jetbrains.annotations.Nullable FirebaseFirestoreException error) {
                fullName = value.getString("last_name") + ", " + value.getString("first_name");
            }
        });
    }
    private void checkUserFeedback(){
        CollectionReference reference = firestore.collection("schools").document(sid)
                .collection("feedbacks");
        Query query = reference.whereEqualTo("user_id", firebaseAuth.getCurrentUser().getUid());
        query.get().addOnSuccessListener(new OnSuccessListener<QuerySnapshot>() {
            @Override
            public void onSuccess(QuerySnapshot queryDocumentSnapshots) {
                if (!queryDocumentSnapshots.isEmpty()){
                    add_feedback.setVisibility(View.GONE);
                }
            }
        });
    }
    private void loadFeedbacks() {
        Query query = firestore.collection("schools").document(sid)
                .collection("feedbacks");
        FirestoreRecyclerOptions<Feedback> options = new FirestoreRecyclerOptions.Builder<Feedback>()
                .setQuery(query, Feedback.class)
                .build();
        adapter = new FirestoreRecyclerAdapter<Feedback, SchoolFeedbackFragment.FeedbackViewHolder>(options) {

            @NonNull
            @NotNull
            @Override
            public SchoolFeedbackFragment.FeedbackViewHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
                View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.feedback_cardview, parent, false);

                return new SchoolFeedbackFragment.FeedbackViewHolder(view);
            }

            @Override
            protected void onBindViewHolder(@NonNull @NotNull SchoolFeedbackFragment.FeedbackViewHolder holder, int position, @NonNull @NotNull Feedback model) {
                if (model.getDisplay_name()){
                    holder.user_name.setText(model.getUser_name());
                } else {
                    holder.user_name.setText(model.getUser_name().replaceAll("\\B[a-z]", "*"));
                }

                checkedWords = model.getFeedback();
                for (String word : words) {
                    Pattern rx = Pattern.compile("\\b" + word + "\\b", Pattern.CASE_INSENSITIVE);
                    checkedWords = rx.matcher(checkedWords).replaceAll(new String(new char[word.length()]).replace('\0', '*'));
                }

//                if (!model.getFeedback().equals(checkedWords)){
//                    Toast.makeText(getContext(), "Inappropriate content", Toast.LENGTH_SHORT).show();
//                }
                holder.user_feedback.setText(checkedWords);

                if (model.getTime() != null){
                    String time = (model.getTime().getMonth()+1) + "/" + model.getTime().getDate() + "/" + (model.getTime().getYear()-100);
                    holder.feedback_time.setText(time);
                }

            }
        };
        feedbacksRecyclerView.setHasFixedSize(true);
        feedbacksRecyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
        feedbacksRecyclerView.setAdapter(adapter);
    }

    public class FeedbackViewHolder extends RecyclerView.ViewHolder {
        public TextView user_name;
        public TextView user_feedback;
        public TextView feedback_time;
        public FeedbackViewHolder(@NonNull @NotNull View itemView) {
            super(itemView);
            user_name = itemView.findViewById(R.id.user_name);
            user_feedback = itemView.findViewById(R.id.user_feedback);
            feedback_time = itemView.findViewById(R.id.feedback_time);
        }
    }
    private void progressDialog(){
        progressDialog = new ProgressDialog(getContext());
        progressDialog.setMessage("Please wait...");
        progressDialog.setCancelable(false);
        progressDialog.setCanceledOnTouchOutside(false);
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

}