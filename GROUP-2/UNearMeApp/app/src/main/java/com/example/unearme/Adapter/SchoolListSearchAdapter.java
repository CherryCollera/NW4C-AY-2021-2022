package com.example.unearme.Adapter;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.unearme.Helper.SchoolInfo;
import com.example.unearme.R;
import com.firebase.ui.firestore.FirestoreRecyclerAdapter;
import com.firebase.ui.firestore.FirestoreRecyclerOptions;
import com.google.firebase.firestore.DocumentSnapshot;
import com.squareup.picasso.Picasso;

import org.jetbrains.annotations.NotNull;

public class SchoolListSearchAdapter extends FirestoreRecyclerAdapter<SchoolInfo, SchoolListSearchAdapter.SchoolListHolder> {

    private OnItemClickListener listener;

    public SchoolListSearchAdapter(@NonNull @NotNull FirestoreRecyclerOptions<SchoolInfo> options) {
        super(options);
    }

    @Override
    protected void onBindViewHolder(@NonNull @NotNull SchoolListHolder holder, int position, @NonNull @NotNull SchoolInfo model) {
        holder.school_name.setText(model.getSchool_name());
        Picasso.get()
                .load(model.getSchool_logo())
                .placeholder(R.drawable.placeholder_img)
                .fit()
                .centerInside()
                .into(holder.school_logo);
        holder.school_municipality.setText(model.getMunicipality());
    }

    @NonNull
    @NotNull
    @Override
    public SchoolListHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.school_list_cardview_filtersearch, parent, false);
        return new SchoolListHolder(view);
    }

    class SchoolListHolder extends RecyclerView.ViewHolder{

        ImageView school_logo;
        TextView school_name, school_municipality;

        public SchoolListHolder(@NonNull @NotNull View itemView) {
            super(itemView);

            school_logo = itemView.findViewById(R.id.school_logo);
            school_name = itemView.findViewById(R.id.school_name);
            school_municipality = itemView.findViewById(R.id.school_municipality);

            itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    int position = getAdapterPosition();
                    if (position != RecyclerView.NO_POSITION && listener != null){
                        listener.onItemClick(getSnapshots().getSnapshot(position), position, school_logo, school_name);
                    }
                }
            });
        }
    }

    public interface OnItemClickListener{
        void onItemClick(DocumentSnapshot documentSnapshot, int position, ImageView school_logo, TextView school_name);
    }

    public void setOnItemClickListener(OnItemClickListener listener){
        this.listener =  listener;
    }
}
