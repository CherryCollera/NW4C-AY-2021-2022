package com.example.unearme;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.Toast;

import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.material.textfield.TextInputLayout;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.GeoPoint;

import org.jetbrains.annotations.NotNull;

import java.util.HashMap;
import java.util.Map;

public class Register extends AppCompatActivity {

    TextInputLayout reg_first_name, reg_last_name, reg_email, reg_password, reg_confirm_password;
    Button reg_btn;
    ProgressDialog progressDialog;
    FirebaseAuth firebaseAuth;
    FirebaseFirestore firestore;
    FirebaseUser user;
    String user_id;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        initWidgets();

        firebaseAuth = FirebaseAuth.getInstance();
        firestore = FirebaseFirestore.getInstance();

        reg_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (!validateFirstname() || !validateLastname() || !validateEmail() || !validatePassword()) {
                    return;
                } else if (!reg_password.getEditText().getText().toString().equals(reg_confirm_password.getEditText().getText().toString())){
                    Toast.makeText(Register.this, "Password do not match" , Toast.LENGTH_SHORT).show();
                    return;
                } else {
                    closeKeyboard();
                    progressDialog.show();
                    String firstname = reg_first_name.getEditText().getText().toString();
                    String lastname = reg_last_name.getEditText().getText().toString();

                    String email = reg_email.getEditText().getText().toString();
                    String password = reg_password.getEditText().getText().toString();

                    firebaseAuth.createUserWithEmailAndPassword(email, password).addOnSuccessListener(new OnSuccessListener<AuthResult>() {
                        @Override
                        public void onSuccess(AuthResult authResult) {
                            progressDialog.dismiss();
                            user = firebaseAuth.getCurrentUser();
                            sendVerification();

                            user_id = firebaseAuth.getCurrentUser().getUid();
                            DocumentReference documentReference = firestore.collection("students").document(user_id);
                            Map<String, Object> students = new HashMap<>();
                            students.put("first_name", firstname);
                            students.put("last_name", lastname);
                            students.put("email", email);
                            documentReference.set(students).addOnSuccessListener(new OnSuccessListener<Void>() {
                                @Override
                                public void onSuccess(Void aVoid) {
                                    Toast.makeText(Register.this, "Please verify your Email", Toast.LENGTH_SHORT).show();
                                    startActivity(new Intent(Register.this, VerifyEmail.class));
                                    finish();
                                }
                            });



                        }
                    }).addOnFailureListener(new OnFailureListener() {
                        @Override
                        public void onFailure(@NonNull Exception e) {
                            progressDialog.dismiss();
                            Toast.makeText(Register.this, e.getMessage(), Toast.LENGTH_LONG).show();
                        }
                    });
                }
            }
        });
    }

    private void sendVerification(){
        user.sendEmailVerification().addOnSuccessListener(new OnSuccessListener<Void>() {
            @Override
            public void onSuccess(Void unused) {
//                startActivity(new Intent(Register.this, VerifyEmail.class));
//                finish();
            }
        }).addOnFailureListener(new OnFailureListener() {
            @Override
            public void onFailure(@NonNull @NotNull Exception e) {
                Toast.makeText(Register.this, e.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }

    private boolean validateFirstname() {
        String val = reg_first_name.getEditText().getText().toString();

        if (val.isEmpty()) {
            reg_first_name.setError("Field cannot be empty");
            reg_first_name.requestFocus();
            return false;
        } else if (val.length() < 2) {
            reg_first_name.setError("Invalid Name");
            reg_first_name.requestFocus();
            return false;
        } else if (!val.matches("[a-zA-Z ]+")) {
            reg_first_name.setError("Letters only");
            reg_first_name.requestFocus();
            return false;
        } else {
            reg_first_name.setError(null);
            reg_first_name.setErrorEnabled(false);
            return true;
        }
    }

    private boolean validateLastname() {
        String val = reg_last_name.getEditText().getText().toString();

        if (val.isEmpty()) {
            reg_last_name.setError("Field cannot be empty");
            reg_last_name.requestFocus();
            return false;
        } else if (val.length() < 2) {
            reg_last_name.setError("Invalid Lastname");
            reg_last_name.requestFocus();
            return false;
        } else if (!val.matches("[a-zA-Z ]+")) {
            reg_last_name.setError("Letters only");
            reg_last_name.requestFocus();
            return false;
        } else {
            reg_last_name.setError(null);
            reg_last_name.setErrorEnabled(false);
            return true;
        }
    }
//
//    private boolean validateAddress() {
//        String val = reg_address.getEditText().getText().toString();
//
//        if (val.isEmpty()) {
//            reg_address.setError("Field cannot be empty");
//            reg_address.requestFocus();
//            return false;
//        } else {
//            reg_address.setError(null);
//            reg_address.setErrorEnabled(false);
//            return true;
//        }
//    }

//    private boolean validateContact() {
//        String val = reg_contact_number.getEditText().getText().toString();
//
//        if (val.isEmpty()) {
//            reg_contact_number.setError("Field cannot be empty");
//            reg_contact_number.requestFocus();
//            return false;
//        } else if (val.length() < 11) {
//            reg_contact_number.setError("Number is too short");
//            reg_contact_number.requestFocus();
//            return false;
//        } else {
//            reg_contact_number.setError(null);
//            reg_contact_number.setErrorEnabled(false);
//            return true;
//        }
//    }

    private boolean validateEmail() {
        String val = reg_email.getEditText().getText().toString();

        if (val.isEmpty()) {
            reg_email.setError("Field cannot be empty");
            reg_email.requestFocus();
            return false;
        } else if (!val.matches("[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+")) {
            reg_email.setError("Invalid Email");
            reg_email.requestFocus();
            return false;
        } else {
            reg_email.setError(null);
            reg_email.setErrorEnabled(false);
            return true;
        }
    }

    private boolean validatePassword() {
        String val = reg_password.getEditText().getText().toString();

        if (val.isEmpty()) {
            reg_password.setError("Field cannot be empty");
            reg_password.requestFocus();
            return false;
        } else if (val.length() < 6) {
            reg_password.setError("Password should be at least 6 characters");
            reg_password.requestFocus();
            return false;
        } else {
            reg_password.setError(null);
            reg_password.setErrorEnabled(false);
            return true;
        }
    }

    private void initWidgets() {
        // Hooks
        reg_first_name = findViewById(R.id.reg_first_name);
        reg_last_name = findViewById(R.id.reg_last_name);
        reg_email = findViewById(R.id.reg_email);
        reg_password = findViewById(R.id.reg_password);
        reg_btn = findViewById(R.id.reg_btn);
        reg_confirm_password = findViewById(R.id.reg_confirm_password);

        // Progress Dialog
        progressDialog = new ProgressDialog(Register.this);
        progressDialog.setMessage("Please wait...");
        progressDialog.setCancelable(false);
        progressDialog.setCanceledOnTouchOutside(false);
    }

    private void closeKeyboard() {
        View view = this.getCurrentFocus();
        if (view != null) {
            InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
            imm.hideSoftInputFromWindow(view.getWindowToken(), 0);
        }
    }


    public void gotoLogin(View view) {
        startActivity(new Intent(Register.this, Login.class));
        finish();
    }
}