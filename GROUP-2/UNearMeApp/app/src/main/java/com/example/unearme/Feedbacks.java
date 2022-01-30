package com.example.unearme;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.unearme.Helper.Feedback;
import com.example.unearme.Helper.SchoolInfo;
import com.firebase.ui.firestore.FirestoreRecyclerAdapter;
import com.firebase.ui.firestore.FirestoreRecyclerOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
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
import com.google.firestore.v1.DocumentTransform;

import org.jetbrains.annotations.NotNull;

import java.util.HashMap;
import java.util.Map;

public class Feedbacks extends AppCompatActivity {

    RecyclerView feedbacksRecyclerView;
    TextView school_name;
    Button add_feedback;
    FirebaseFirestore firestore;
    FirebaseAuth firebaseAuth;
    FirestoreRecyclerAdapter adapter;
    String fullName, feedback, sid;
    ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_feedbacks);
        progressDialog();
        feedbacksRecyclerView = findViewById(R.id.feedbacksRecyclerView);
        school_name = findViewById(R.id.school_name);
        add_feedback = findViewById(R.id.add_feedback);

        firebaseAuth = FirebaseAuth.getInstance();
        firestore = FirebaseFirestore.getInstance();

        Intent intent = getIntent();
        sid = intent.getStringExtra("school_id");

//        loadUserInfo();
//        checkUserFeedback();
//        loadFeedbacks();


        add_feedback.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showFeedbackDialog();
            }
        });

    }

    private void showFeedbackDialog() {
        final AlertDialog.Builder builder = new AlertDialog.Builder(Feedbacks.this);
        View view = getLayoutInflater().inflate(R.layout.add_feedback_dialog, null);

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
                    addFeedback();
                    alertDialog.dismiss();
                }
            }
        });

        alertDialog.show();
    }

    private void loadFeedbacks() {
        Query query = firestore.collection("schools").document(sid)
                .collection("feedbacks");
        FirestoreRecyclerOptions<Feedback> options = new FirestoreRecyclerOptions.Builder<Feedback>()
                .setQuery(query, Feedback.class)
                .build();
        adapter = new FirestoreRecyclerAdapter<Feedback, FeedbackViewHolder>(options) {

            @NonNull
            @NotNull
            @Override
            public FeedbackViewHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
                View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.feedback_cardview, parent, false);

                return new FeedbackViewHolder(view);
            }

            @Override
            protected void onBindViewHolder(@NonNull @NotNull Feedbacks.FeedbackViewHolder holder, int position, @NonNull @NotNull Feedback model) {
                holder.user_name.setText(model.getUser_name());
                holder.user_feedback.setText(model.getFeedback());
            }
        };
        feedbacksRecyclerView.setHasFixedSize(true);
        feedbacksRecyclerView.setLayoutManager(new LinearLayoutManager(Feedbacks.this));
        feedbacksRecyclerView.setAdapter(adapter);
    }
    public static class FeedbackViewHolder extends RecyclerView.ViewHolder{

        public TextView user_name;
        public TextView user_feedback;

        public FeedbackViewHolder(@NonNull @NotNull View itemView) {
            super(itemView);
            user_name = itemView.findViewById(R.id.user_name);
            user_feedback = itemView.findViewById(R.id.user_feedback);
        }
    }

    private void addFeedback(){
        Map<String, Object> feedback_info = new HashMap<>();
        feedback_info.put("user_name", fullName);
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

    private void loadUserInfo(){
        DocumentReference documentReference = firestore.collection("students").document(firebaseAuth.getCurrentUser().getUid());
        documentReference.addSnapshotListener(Feedbacks.this, new EventListener<DocumentSnapshot>() {
            @Override
            public void onEvent(@Nullable DocumentSnapshot value, @Nullable FirebaseFirestoreException error) {
                fullName = value.getString("last_name") + ", " + value.getString("first_name");
            }
        });
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

    private void progressDialog(){
        progressDialog = new ProgressDialog(Feedbacks.this);
        progressDialog.setMessage("Please wait...");
        progressDialog.setCancelable(false);
        progressDialog.setCanceledOnTouchOutside(false);
    }

}