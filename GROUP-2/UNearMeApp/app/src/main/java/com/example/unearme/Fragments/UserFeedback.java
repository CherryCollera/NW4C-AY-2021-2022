package com.example.unearme.Fragments;

import android.app.ProgressDialog;
import android.os.Bundle;

import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;

import android.text.Editable;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;

import com.example.unearme.R;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.FieldValue;
import com.google.firebase.firestore.FirebaseFirestore;

import java.util.HashMap;
import java.util.Map;

public class UserFeedback extends Fragment {

    public UserFeedback() {
        // Required empty public constructor
    }

    ProgressDialog progressDialog;
    CardView rootLayout;
    EditText feedback_subject, feedback_description;
    Button send_user_feedback;

    FirebaseFirestore firestore;
    FirebaseAuth firebaseAuth;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_user_feedback, container, false);
        // Progress Dialog
        progressDialog = new ProgressDialog(getContext());
        progressDialog.setMessage("Please wait...");
        rootLayout = view.findViewById(R.id.rootLayout);

        firestore = FirebaseFirestore.getInstance();
        firebaseAuth = FirebaseAuth.getInstance();

        feedback_subject = view.findViewById(R.id.feedback_subject);
        feedback_description = view.findViewById(R.id.feedback_description);
        send_user_feedback = view.findViewById(R.id.send_user_feedback);
        feedback_description.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) { }
            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) { }
            @Override
            public void afterTextChanged(Editable s) {
                if (s.toString().isEmpty()){
                    send_user_feedback.setEnabled(false);
                } else {
                    send_user_feedback.setEnabled(true);
                }
            }
        });
        send_user_feedback.setOnClickListener(new View.OnClickListener() {
              @Override
              public void onClick(View v) {
                  progressDialog.show();
                  sendFeedback();

              }
        });
        // Inflate the layout for this fragment
        return view;
    }
        private void sendFeedback() {
            Map<String, Object> report_info = new HashMap<>();
            report_info.put("user_email", firebaseAuth.getCurrentUser().getEmail());
            report_info.put("subject", feedback_subject.getText().toString());
            report_info.put("description", feedback_description.getText().toString()  );
            report_info.put("user_id", firebaseAuth.getCurrentUser().getUid());
            report_info.put("time", FieldValue.serverTimestamp());
            firestore.collection("user_feedbacks")
                    .add(report_info)
                    .addOnSuccessListener(new OnSuccessListener<DocumentReference>() {
                        @Override
                        public void onSuccess(DocumentReference documentReference) {
                            feedback_subject.setText("");
                            feedback_description.setText("");
                            progressDialog.dismiss();
                            Snackbar.make(rootLayout, "Thank you for sharing your thoughts.", Snackbar.LENGTH_LONG)
                                    .show();

                        }
                    });
        }
}