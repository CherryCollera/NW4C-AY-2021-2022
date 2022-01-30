package com.example.unearme;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Toast;

import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.material.snackbar.Snackbar;
import com.google.android.material.textfield.TextInputLayout;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.FirebaseFirestore;

public class Login extends AppCompatActivity implements View.OnClickListener {

    // Widgets
    TextInputLayout login_email, login_password;
    CheckBox remember_me;
    ProgressDialog progressDialog;
    ConstraintLayout rootLayout;

    FirebaseAuth firebaseAuth;
    FirebaseFirestore firestore;
    FirebaseUser user;

    //private static final String ADMIN = "school_admin";
    private static final String STUDENT = "student";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        initWidgets();

        firebaseAuth = FirebaseAuth.getInstance();
        firestore = FirebaseFirestore.getInstance();

        checkRememberMe();
    }
    // Button onClicks
    @Override
    public void onClick(View button) {
        switch (button.getId()){
            // Login
            case R.id.gotoMainPage:
                // Validate email and password
                if (!validateEmail() || !validatePassword()) {
                    return;
                } else {
                    removeFocus();
                    progressDialog.show();
                    String email = login_email.getEditText().getText().toString();
                    String password = login_password.getEditText().getText().toString();

                    // Sign in User
                    firebaseAuth.signInWithEmailAndPassword(email, password).addOnSuccessListener(new OnSuccessListener<AuthResult>() {
                        @Override
                        public void onSuccess(AuthResult authResult) {
                            user = firebaseAuth.getCurrentUser();
                            progressDialog.dismiss();
                            // Get Data from School admin
                            DocumentReference reference = firestore.collection(getString(R.string.collection_students)).document(firebaseAuth.getCurrentUser().getUid());
                            reference.get().addOnSuccessListener(new OnSuccessListener<DocumentSnapshot>() {
                                @Override
                                public void onSuccess(DocumentSnapshot documentSnapshot) {
//                                    Toast.makeText(Login.this, documentSnapshot.exists()+"", Toast.LENGTH_SHORT).show();
                                    // If empty Login as student
                                    if (user.isEmailVerified()){
                                        if (documentSnapshot.exists()) {
                                            rememberMe(STUDENT, null);
                                            Toast.makeText(Login.this, "Login Successfully", Toast.LENGTH_SHORT).show();
                                            startActivity(new Intent(Login.this, MainPage.class));
                                            finish();
                                        } else {
                                            progressDialog.dismiss();
                                            Toast.makeText(Login.this, "Unable to login", Toast.LENGTH_SHORT).show();
                                        }
                                    } else {
                                        startActivity(new Intent(Login.this, VerifyEmail.class));
                                        finish();
                                    }
                                }
                            });
                        }
                    }).addOnFailureListener(new OnFailureListener() {
                        @Override
                        public void onFailure(@NonNull Exception e) {
                            progressDialog.dismiss();
                            Toast.makeText(Login.this, "Wrong Email or Password", Toast.LENGTH_SHORT).show();
                        }
                    });
                }

                break;
            // SignUp
            case R.id.gotoRegister:
                Intent intent = new Intent(Login.this, Register.class);
                startActivity(intent);
                break;
            // Forgot password
            case R.id.forgot_password:
                showForgotPassword();
        }

    }

    private void checkRememberMe() {
        SharedPreferences preferences = getSharedPreferences("checkbox", MODE_PRIVATE);
        String check = preferences.getString("remember_me", "");
        if (check.equals("student")){
            startActivity(new Intent(Login.this, MainPage.class));
            finish();
        }
        if (check.equals("false")){
        }
    }

    private void rememberMe(String user, String school_id){
        if (remember_me.isChecked()){
            if (user.equals(STUDENT)){
                SharedPreferences preferences = getSharedPreferences("checkbox", MODE_PRIVATE);
                SharedPreferences.Editor editor = preferences.edit();
                editor.putString("remember_me", user);
                editor.putString("school_id", school_id);
                editor.apply();
            }

        } else if (!remember_me.isChecked()){
            SharedPreferences preferences = getSharedPreferences("checkbox", MODE_PRIVATE);
            SharedPreferences.Editor editor = preferences.edit();
            editor.putString("remember_me", "false");
            editor.putString("school_id", school_id);
            editor.apply();
        }
    }

    private void showForgotPassword() {
        final AlertDialog.Builder builder = new AlertDialog.Builder(Login.this);
        View view = getLayoutInflater().inflate(R.layout.reset_password, null);

        EditText reset_email = view.findViewById(R.id.reset_email);
        Button reset_yes = view.findViewById(R.id.reset_yes);

        builder.setView(view);
        final AlertDialog alertDialog = builder.create();
        alertDialog.getWindow().setBackgroundDrawableResource(R.color.transparent);

        reset_yes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                String email = reset_email.getText().toString();

                if (email.isEmpty()) {
                    reset_email.setError("Enter your email");
                    reset_email.requestFocus();
                } else if (!email.matches("[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+")) {
                    reset_email.setError("Invalid Email");
                    reset_email.requestFocus();
                    Toast.makeText(Login.this, "Invalid email", Toast.LENGTH_SHORT).show();
                } else {
                    progressDialog.show();
                    alertDialog.dismiss();
                    reset_email.onEditorAction(EditorInfo.IME_ACTION_DONE);
                    firebaseAuth.sendPasswordResetEmail(email).addOnSuccessListener(new OnSuccessListener<Void>() {
                        @Override
                        public void onSuccess(Void unused) {
                            progressDialog.dismiss();
                            Snackbar.make(rootLayout, "Reset link has been sent to your email", Snackbar.LENGTH_LONG)
                            .show();
                        }
                    });
                }
            }
        });

        alertDialog.show();
    }

    private boolean validateEmail() {
        String val = login_email.getEditText().getText().toString();

        if (val.isEmpty()) {
            login_email.setError("Field cannot be empty");
            login_email.requestFocus();
            return false;
        } else if (!val.matches("[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+")) {
            login_email.setError("Invalid Email");
            login_email.requestFocus();
            return false;
        } else {
            login_email.setError(null);
            login_email.setErrorEnabled(false);
            return true;
        }
    }

    private boolean validatePassword() {
        String val = login_password.getEditText().getText().toString();

        if (val.isEmpty()) {
            login_password.setError("Field cannot be empty");
            login_password.requestFocus();
            return false;
        } else {
            login_password.setError(null);
            login_password.setErrorEnabled(false);
            return true;
        }
    }

    private void initWidgets(){
        findViewById(R.id.gotoRegister).setOnClickListener(this);
        findViewById(R.id.forgot_password).setOnClickListener(this);
        findViewById(R.id.gotoMainPage).setOnClickListener(this);

        rootLayout = findViewById(R.id.rootLayout);
        login_email = findViewById(R.id.login_email);
        login_password = findViewById(R.id.login_password);
        remember_me = findViewById(R.id.remember_me);

        progressDialog = new ProgressDialog(Login.this);
        progressDialog.setMessage("Please wait...");
        progressDialog.setCancelable(false);
        progressDialog.setCanceledOnTouchOutside(false);
    }



    @Override
    public void onBackPressed() {
        finishAffinity();
    }

    private void removeFocus(){
        View view = this.getCurrentFocus();
        if (view != null){
            InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
            imm.hideSoftInputFromWindow(view.getWindowToken(), 0);
        }
    }
}