package com.example.unearme;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.text.Html;
import android.widget.TextView;

public class Result extends AppCompatActivity {

    TextView tvprogram, tvdescription;
    public static final String PROGRAM = "PROGRAM";
    public static final String DESCRIPTION = "DESCRIPTION";
    private String program;
    private String description;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_result);

        tvprogram = findViewById(R.id.program);
        tvdescription = findViewById(R.id.description);

        Intent i = getIntent();
        program = i.getStringExtra(PROGRAM);
        description = i.getStringExtra(DESCRIPTION);

        tvprogram.setText(Html.fromHtml("&ldquo;"+program+"&rdquo;"));
        tvdescription.setText(description);
    }

    @Override
    public void onBackPressed() {
        startActivity(new Intent(Result.this, MainPage.class));
        finish();
    }
}