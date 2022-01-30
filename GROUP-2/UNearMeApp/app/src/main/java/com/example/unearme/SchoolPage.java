package com.example.unearme;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentPagerAdapter;
import androidx.viewpager.widget.ViewPager;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.unearme.Fragments.SchoolInfoFragment;
import com.example.unearme.Fragments.SchoolProgramsFragment;
import com.example.unearme.Fragments.SchoolFeedbackFragment;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.android.material.tabs.TabLayout;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.FirebaseFirestore;
import com.squareup.picasso.Picasso;

import org.jetbrains.annotations.NotNull;

import java.util.ArrayList;

public class SchoolPage extends AppCompatActivity {

    TabLayout tab_layout;
    ViewPager view_pager;
    MainAdapter adapter;
    TextView school_page_name;
    ImageButton back_btn;
    ImageView school_page_logo;
    FirebaseFirestore firestore;
    Button viewTour;

    String sid;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_school_page);

        tab_layout = findViewById(R.id.tab_layout);
        view_pager = findViewById(R.id.view_pager);
        school_page_name = findViewById(R.id.school_page_name);
        school_page_logo = findViewById(R.id.school_page_logo);
        viewTour = findViewById(R.id.view_tour);
        firestore = FirebaseFirestore.getInstance();
        // Getting data object
        Intent intent = getIntent();
        sid = intent.getStringExtra("school_id");

        viewTour.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(SchoolPage.this, VirtualTour.class)
                .putExtra("school_id", sid));
            }
        });

        //SchoolInfo school_info = intent.getParcelableExtra("school_info");

        adapter = new MainAdapter(getSupportFragmentManager());
        // Sending data object to fragment
        Bundle bundle =new Bundle();
        //bundle.putParcelable("school_info", school_info);
        bundle.putString("school_id", sid);

        SchoolInfoFragment schoolInfoFragment = new SchoolInfoFragment();
        schoolInfoFragment.setArguments(bundle);

        SchoolProgramsFragment schoolProgramsFragment = new SchoolProgramsFragment();
        schoolProgramsFragment.setArguments(bundle);

        SchoolFeedbackFragment schoolFeedbackFragment = new SchoolFeedbackFragment();
        schoolFeedbackFragment.setArguments(bundle);

        loadSchoolNameAndLogo();





        // setting up fragment
        adapter.Addfragment(schoolInfoFragment, "Info");
        adapter.Addfragment(schoolProgramsFragment, "Programs");
        adapter.Addfragment(schoolFeedbackFragment, "Feedbacks");

        view_pager.setAdapter(adapter);

        tab_layout.setupWithViewPager(view_pager);
        back_btn = findViewById(R.id.back_btn);

        back_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(SchoolPage.this, MainPage.class));
                finish();
            }
        });

    }

    private void loadSchoolNameAndLogo(){
        DocumentReference reference = firestore.collection("schools").document(sid);
        reference.get().addOnCompleteListener(new OnCompleteListener<DocumentSnapshot>() {
            @Override
            public void onComplete(@NonNull @NotNull Task<DocumentSnapshot> task) {
                if (task.isSuccessful()){


                    Picasso.get()
                            .load(task.getResult().getString("school_logo"))
                            .placeholder(R.drawable.placeholder_img)
                            .fit()
                            .centerInside()
                            .into(school_page_logo);
                     school_page_name.setText(task.getResult().getString("school_name"));
                }
            }
        });
    }

    private class MainAdapter extends FragmentPagerAdapter {

        ArrayList<Fragment> fragmentArrayList = new ArrayList<>();
        ArrayList<String> stringArrayList = new ArrayList<>();


        public void Addfragment(Fragment fragment, String s) {
            fragmentArrayList.add(fragment);
            stringArrayList.add(s);
        }

        public MainAdapter(@NonNull @NotNull FragmentManager fm) {
            super(fm);
        }
        @NonNull
        @NotNull
        @Override
        public Fragment getItem(int position) {
            return fragmentArrayList.get(position);
        }

        @Override
        public int getCount() {
            return fragmentArrayList.size();
        }
        @Nullable
        @org.jetbrains.annotations.Nullable
        @Override
        public CharSequence getPageTitle(int position) {
            return stringArrayList.get(position);
        }
    }

    @Override
    public void onBackPressed() {
        startActivity(new Intent(SchoolPage.this, MainPage.class));
        finish();
    }
}