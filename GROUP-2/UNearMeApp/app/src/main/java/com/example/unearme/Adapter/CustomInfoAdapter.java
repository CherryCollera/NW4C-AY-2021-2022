package com.example.unearme.Adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.unearme.R;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.model.Marker;

import org.jetbrains.annotations.NotNull;

public class CustomInfoAdapter implements GoogleMap.InfoWindowAdapter {

    private final View mView;
    private Context mContext;

    public CustomInfoAdapter(Context context){
        mContext = context;
        mView = LayoutInflater.from(context).inflate(R.layout.custom_info_window, null);
    }
    private void renderWindowText(Marker marker, View view){
        String title = marker.getTitle();
        TextView tvTitle = (TextView) view.findViewById(R.id.infoWindowTitle);

        if (!title.equals("")){
            tvTitle.setText(title);
        }
        String snippet = marker.getTitle();
        TextView tvSnipper = (TextView) view.findViewById(R.id.infoWindowSnippet);

        if (!snippet.equals("")){
            tvSnipper.setText(snippet);
        }
    }

    @Nullable
    @org.jetbrains.annotations.Nullable
    @Override
    public View getInfoWindow(@NonNull @NotNull Marker marker) {
        renderWindowText(marker, mView);
        return mView;
    }

    @Nullable
    @org.jetbrains.annotations.Nullable
    @Override
    public View getInfoContents(@NonNull @NotNull Marker marker) {
        renderWindowText(marker, mView);
        return mView;
    }
}
