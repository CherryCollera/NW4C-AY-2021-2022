package com.example.unearme;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.os.Handler;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.firestore.FirebaseFirestore;

import org.jetbrains.annotations.NotNull;

public class VerifyEmail extends AppCompatActivity {

    Button btnresend_verification;
    TextView tvtimer;

    FirebaseAuth firebaseAuth;
    FirebaseFirestore firestore;
    FirebaseUser user;

    private Handler handler = new Handler();
//    Runnable runnable;
//    int delay = 1000;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_verify_email);
        initWidgets();
        firebaseAuth = FirebaseAuth.getInstance();
        firestore = FirebaseFirestore.getInstance();
        user = firebaseAuth.getCurrentUser();

        countdown();
       authListener.run();

        btnresend_verification.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                btnresend_verification.setEnabled(false);
                user.sendEmailVerification().addOnSuccessListener(new OnSuccessListener<Void>() {
                    @Override
                    public void onSuccess(Void unused) {
                        countdown();
                    }
                }).addOnFailureListener(new OnFailureListener() {
                    @Override
                    public void onFailure(@NonNull @NotNull Exception e) {
                        Toast.makeText(VerifyEmail.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                });

            }
        });

    }


    private Runnable authListener = new Runnable() {
        @Override
        public void run() {
            user.reload().addOnSuccessListener(new OnSuccessListener<Void>() {
                @Override
                public void onSuccess(Void unused) {
                    if (user.isEmailVerified()){
                        startActivity(new Intent(VerifyEmail.this, MainPage.class));
                        finish();
                        handler.removeCallbacks(authListener);
                    }
                }
            });
            handler.postDelayed( authListener, 1000);
        }
    };
    public void countdown(){
        tvtimer.setVisibility(View.VISIBLE);
        new CountDownTimer(60000, 1000) {

            public void onTick(long millisUntilFinished) {

                tvtimer.setText(millisUntilFinished / 1000 + "s");
            }

            public void onFinish() {
                tvtimer.setVisibility(View.GONE);
                btnresend_verification.setEnabled(true);
            }
        }.start();
    }

    private void initWidgets(){
        btnresend_verification = findViewById(R.id.resend_verification);
        tvtimer = findViewById(R.id.timer);
    }
}