package com.example.unearme;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Handler;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.auth.AuthCredential;
import com.google.firebase.auth.EmailAuthProvider;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.EventListener;
import com.google.firebase.firestore.FieldValue;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.FirebaseFirestoreException;
import com.google.firebase.firestore.GeoPoint;

import org.jetbrains.annotations.NotNull;

import java.util.HashMap;
import java.util.Map;

public class Profile extends AppCompatActivity {

    ConstraintLayout rootLayout;
    Button send_report;
    EditText display_first_name, display_last_name,  display_email, enter_password;
    Button btn_editProfile, btn_updateProfile, btn_cancel;
    LinearLayout cancel_save;
    ProgressDialog progressDialog;
    FirebaseAuth firebaseAuth;
    FirebaseFirestore firestore;
    String user_id, fullName;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);
        initWidgets();
        progressDialog();
        firebaseAuth = FirebaseAuth.getInstance();
        firestore = FirebaseFirestore.getInstance();
        user_id = firebaseAuth.getCurrentUser().getUid();
        loadUserInfo();




        btn_editProfile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                btn_editProfile.setVisibility(View.GONE);
                cancel_save.setVisibility(View.VISIBLE);
                display_first_name.setFocusableInTouchMode(true);
                display_last_name.setFocusableInTouchMode(true);
                display_email.setFocusableInTouchMode(true);


            }
        });

        btn_cancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                hideSoftKeyboard();
                loadUserInfo();
                enter_password.setText("");
                btn_editProfile.setVisibility(View.VISIBLE);
                cancel_save.setVisibility(View.GONE);
                display_first_name.setFocusableInTouchMode(false);
                display_last_name.setFocusableInTouchMode(false);
                display_email.setFocusableInTouchMode(false);


            }
        });

        btn_updateProfile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (!enter_password.getText().toString().isEmpty()){
                    hideSoftKeyboard();
                    progressDialog.show();
                    if (!validateEmail()){
                        progressDialog.dismiss();
                        return;
                    }
                    updateProfile();
                }
            }
        });


    }


//    @Override
//    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
//        super.onActivityResult(requestCode, resultCode, data);
//        if (requestCode == 1) {
//            if (resultCode == RESULT_OK) {
//                double latitude = data.getDoubleExtra("latitude", 0);
//                double longitude = data.getDoubleExtra("longitude", 0);
//                geoPoint = new GeoPoint(latitude, longitude);
//                display_address.setText(data.getStringExtra("complete_address"));
//            }
//        }
//
//    }

    private void updateProfile() {
        FirebaseUser user = FirebaseAuth.getInstance().getCurrentUser();
        // Get auth credentials from the user for re-authentication
        AuthCredential credential = EmailAuthProvider
                .getCredential(user.getEmail(), enter_password.getText().toString()); // Current Login Credentials \\
        // Prompt the user to re-provide their sign-in credentials
        user.reauthenticate(credential)
                .addOnSuccessListener(new OnSuccessListener<Void>() {
                    @Override
                    public void onSuccess(Void unused) {
                        Log.d("TAG", "User re-authenticated.");

                        //Now change your email address \\
                        //----------------Code for Changing Email Address----------\\
                        FirebaseUser user = FirebaseAuth.getInstance().getCurrentUser();
                        user.updateEmail(display_email.getText().toString())
                                .addOnSuccessListener(new OnSuccessListener<Void>() {
                                    @Override
                                    public void onSuccess(Void unused) {
                                        Log.d("TAG", "User email address updated.");

                                        //Now change profile info\\
                                        DocumentReference reference = firestore.collection("students").document(user_id);
                                        Map<String, Object> students = new HashMap<>();
                                        students.put("first_name", display_first_name.getText().toString());
                                        students.put("last_name", display_last_name.getText().toString());
                                        students.put("email", display_email.getText().toString());
                                        reference.update(students);

                                        Toast.makeText(Profile.this, "Updated Successfully", Toast.LENGTH_SHORT).show();
                                        cancel_save.setVisibility(View.GONE);
                                        enter_password.setText("");
                                        btn_editProfile.setVisibility(View.VISIBLE);
                                        display_first_name.setFocusableInTouchMode(false);
                                        display_last_name.setFocusableInTouchMode(false);
                                        display_email.setFocusableInTouchMode(false);

                                    }
                                }).addOnFailureListener(new OnFailureListener() {
                            @Override
                            public void onFailure(@NonNull @NotNull Exception e) {
                                Toast.makeText(Profile.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                            }
                        });
                        //----------------------------------------------------------\\
                        progressDialog.dismiss();
                    }
                }).addOnFailureListener(new OnFailureListener() {
            @Override
            public void onFailure(@NonNull @NotNull Exception e) {
                Log.d("TAG", e.getMessage());
                Toast.makeText(Profile.this, "Wrong password", Toast.LENGTH_SHORT).show();
                progressDialog.dismiss();

            }
        });
    }

    private void loadUserInfo(){
        DocumentReference documentReference = firestore.collection("students").document(user_id);
        documentReference.addSnapshotListener(Profile.this, new EventListener<DocumentSnapshot>() {
            @Override
            public void onEvent(@Nullable DocumentSnapshot value, @Nullable FirebaseFirestoreException error) {
                display_first_name.setText(value.getString("first_name"));
                display_last_name.setText(value.getString("last_name"));
                display_email.setText(value.getString("email"));
                fullName = value.getString("last_name") + ", " + value.getString("first_name");
            }
        });
    }
    private void initWidgets(){
        // Hooks
        display_first_name = findViewById(R.id.display_first_name);
        display_last_name = findViewById(R.id.display_last_name);
        display_email = findViewById(R.id.display_email);
        enter_password = findViewById(R.id.enter_password);
        btn_editProfile = findViewById(R.id.btn_editProfile);
        btn_updateProfile = findViewById(R.id.btn_updateProfile);
        btn_cancel = findViewById(R.id.btn_cancel);
        cancel_save = findViewById(R.id.cancel_save);
        rootLayout = findViewById(R.id.rootLayout);
    }
    private void progressDialog(){
        progressDialog = new ProgressDialog(Profile.this);
        progressDialog.setMessage("Please wait...");
        progressDialog.setCancelable(false);
        progressDialog.setCanceledOnTouchOutside(false);
    }

    private void hideSoftKeyboard() {
        View view = this.getCurrentFocus();
        if (view != null){
            view.clearFocus();
            InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
            imm.hideSoftInputFromWindow(view.getWindowToken(), 0);
        }

    }

    private boolean validateEmail() {
        String val = display_email.getText().toString();
        if (!val.matches("[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+")) {
            display_email.setError("Invalid Email");
            display_email.requestFocus();
            return false;
        } else if (val.isEmpty()){
            return false;
        }else {
            display_email.setError(null);
            return true;
        }
    }

    @Override
    public void onBackPressed() {
        startActivity(new Intent(Profile.this, MainPage.class));
        finish();
    }
}