package com.example.unearme;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Handler;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.example.unearme.Fragments.CompareFragment;
import com.example.unearme.Fragments.HomeFragment;
import com.example.unearme.Fragments.MapByProvince;
import com.example.unearme.Fragments.NearMe;
import com.example.unearme.Fragments.SearchFragment;
import com.example.unearme.Fragments.UserFeedback;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.navigation.NavigationView;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.EventListener;
import com.google.firebase.firestore.FieldValue;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.FirebaseFirestoreException;

import org.jetbrains.annotations.NotNull;

import java.util.HashMap;
import java.util.Map;

public class MainPage extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {

    private long backPressedTime;
    static final float END_SCALE = 0.7f;
    ProgressDialog progressDialog;
    Snackbar snackbar;
    Boolean drawer = false;

    FirebaseAuth firebaseAuth;
    FirebaseFirestore firestore;
    String user_id;

    BottomNavigationView bottomNavigationView;

    final Fragment fragment1 = new HomeFragment();
    final Fragment fragment2 = new SearchFragment();
    final Fragment fragment3 = new CompareFragment();
    final Fragment fragment4 = new NearMe();
    final Fragment fragment5 = new MapByProvince();
    final Fragment fragment6 = new UserFeedback();
    final FragmentManager fm = getSupportFragmentManager();
    Fragment active = fragment1;

    // Drawer Menu
    DrawerLayout drawerLayout;
    NavigationView navigationView;
    Toolbar toolbar;
    LinearLayout contentView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_main_page);


        firebaseAuth = FirebaseAuth.getInstance();
        firestore = FirebaseFirestore.getInstance();
        user_id = firebaseAuth.getCurrentUser().getUid();

        //bottomNavigationView = findViewById(R.id.bottomNavigationBar);

        drawerLayout = findViewById(R.id.drawer_layout);
        navigationView = findViewById(R.id.navigation_view);
        toolbar = findViewById(R.id.toolbar);
        contentView = findViewById(R.id.contentView);

        // Progress Dialog
        progressDialog = new ProgressDialog(this);



        setSupportActionBar(toolbar);

        // Navigation Drawer Menu
        navigationView.bringToFront();
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawerLayout, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawerLayout.addDrawerListener(toggle);
        toggle.syncState();

        getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, fragment1).commit();
        navigationView.setCheckedItem(R.id.nav_home);

        navigationView.setNavigationItemSelectedListener(this);
        animateNavigationDrawer();

//        fm.beginTransaction().add(R.id.fragment_container, fragment3, "3").hide(fragment3).commit();
//        fm.beginTransaction().add(R.id.fragment_container, fragment2, "2").hide(fragment2).commit();
//        fm.beginTransaction().add(R.id.fragment_container,fragment1, "1").commit();
//
//        bottom_nav();
        getUserProfile();


    }

    private void getUserProfile() {
        View headerMenu =  navigationView.getHeaderView(0);
        TextView user_name =  headerMenu.findViewById(R.id.user_name);
        TextView user_email = headerMenu.findViewById(R.id.user_email);
        LinearLayout goToProfile =  headerMenu.findViewById(R.id.profile);

        DocumentReference documentReference = firestore.collection("students").document(user_id);
        documentReference.addSnapshotListener(MainPage.this, new EventListener<DocumentSnapshot>() {
            @Override
            public void onEvent(@Nullable DocumentSnapshot value, @Nullable FirebaseFirestoreException error) {
                user_name.setText(value.getString("first_name") + " "+ value.getString("last_name") );
                user_email.setText(value.getString("email"));

            }
        });

        goToProfile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(MainPage.this, Profile.class));
                finish();
            }
        });
    }

    private void animateNavigationDrawer() {
        drawerLayout.addDrawerListener(new DrawerLayout.SimpleDrawerListener() {
            @Override
            public void onDrawerSlide(View drawerView, float slideOffset) {
                // Scale the View based on current slide offset
                final float diffScaledOffset = slideOffset * (1 - END_SCALE);
                final float offsetScale = 1 - diffScaledOffset;
                contentView.setScaleX(offsetScale);
                contentView.setScaleY(offsetScale);

                // Translate the View, accounting for the scaled width
                final float xOffset = drawerView.getWidth() * slideOffset;
                final float xOffsetDiff = contentView.getWidth() * diffScaledOffset / 2;
                final float xTranslation = xOffset - xOffsetDiff;
                contentView.setTranslationX(xTranslation);
            }
        });

    }

    private void bottom_nav() {
        bottomNavigationView.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull @org.jetbrains.annotations.NotNull MenuItem item) {
                switch (item.getItemId()){
                    case R.id.bottom_navigation_home:
                        fm.beginTransaction().hide(active).show(fragment1).commit();
                        active = fragment1;

                        break;
                    case R.id.bottom_navigation_search:
                        fm.beginTransaction().hide(active).show(fragment2).commit();
                        active = fragment2;
                        break;
                    case R.id.bottom_navigation_compare:
                        fm.beginTransaction().hide(active).show(fragment3).commit();
                        active = fragment3;
                        break;


                }
                return true;
            }

        });
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull @NotNull MenuItem item) {
        getSupportFragmentManager().popBackStack(null, FragmentManager.POP_BACK_STACK_INCLUSIVE);

        switch (item.getItemId()) {
            case R.id.nav_home:
                getSupportActionBar().setTitle("U Near Me");
                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, fragment1).commit();
                break;
            case R.id.nav_search:
                getSupportActionBar().setTitle("Filter Search");
                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, fragment2).commit();
                break;
            case R.id.nav_compare:
                getSupportActionBar().setTitle("Compare");
                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, fragment3).commit();
                break;
            case R.id.nav_map_near_me:
                getSupportActionBar().setTitle("U Near Me");
                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, fragment4).commit();
                break;
            case R.id.nav_map_by_province:
                getSupportActionBar().setTitle("U Near Me");
                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, fragment5).commit();
                break;
            case R.id.nav_feedback:
                getSupportActionBar().setTitle("Send a feedback");
                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, fragment6).commit();

                break;
            case R.id.nav_logout:
                drawer = true;
                showLogoutDialog();

                break;
//            case R.id.nav_logout:
//                progressDialog.show();
//                new Handler().postDelayed(new Runnable() {
//                    @Override
//                    public void run() {
//                        AdminPage.this.finish();
//                        progressDialog.dismiss();
//                    }
//                }, 2000);
        }
        if (!drawer){
            drawerLayout.closeDrawer(GravityCompat.START);
        }

        return true;
    }

    private void showLogoutDialog() {
        AlertDialog.Builder builder = new AlertDialog.Builder(MainPage.this);
        builder.setTitle("Log out");
        builder.setMessage("Are you sure you want to logout?");
        builder.setPositiveButton("Yes", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                progressDialog.setMessage("Logging out...");
                progressDialog.show();
                Handler handler = new Handler();
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        progressDialog.dismiss();
                        SharedPreferences preferences = getSharedPreferences("checkbox", MODE_PRIVATE);
                        SharedPreferences.Editor editor = preferences.edit();
                        editor.putString("remember_me", "false");
                        editor.apply();
                        FirebaseAuth.getInstance().signOut();
                        finish();
                        startActivity(new Intent(getApplicationContext(), Login.class));

                    }
                }, 1000);
                    }
                });
                builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                    }
                });
                builder.show();
    }


    @Override
    public void onBackPressed() {
        if (drawerLayout.isDrawerOpen(GravityCompat.START)) {
            drawerLayout.closeDrawer(GravityCompat.START);
        } else {
            if (backPressedTime + 2000 > System.currentTimeMillis()){
                snackbar.dismiss();
                finishAffinity();
                System.exit(1);
                return;
            } else {
                snackbar =  Snackbar.make(drawerLayout, "Press back again to exit", Snackbar.LENGTH_SHORT);
                snackbar.show();
            }
            backPressedTime = System.currentTimeMillis();
//                AlertDialog.Builder builder = new AlertDialog.Builder(MainPage.this);
//                builder.setTitle("Log out");
//                builder.setMessage("Are you sure you want to exit?");
//                builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
//                    @Override
//                    public void onClick(DialogInterface dialog, int which) {
//                        progressDialog.show();
//                        new Handler().postDelayed(new Runnable() {
//                            @Override
//                            public void run() {
//                                finish();
//                                progressDialog.dismiss();
//                            }
//                        }, 2000);
//
//                    }
//                });
//                builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
//                    @Override
//                    public void onClick(DialogInterface dialog, int which) {
//                    }
//                });
//                builder.show();
        }
    }
}