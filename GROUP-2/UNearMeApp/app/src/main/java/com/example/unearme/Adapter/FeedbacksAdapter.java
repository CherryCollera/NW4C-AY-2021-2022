package com.example.unearme.Adapter;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.unearme.Feedbacks;
import com.example.unearme.Helper.Feedback;
import com.example.unearme.R;
import com.firebase.ui.firestore.FirestoreRecyclerAdapter;
import com.firebase.ui.firestore.FirestoreRecyclerOptions;

import org.jetbrains.annotations.NotNull;

public class FeedbacksAdapter extends FirestoreRecyclerAdapter<Feedback, FeedbacksAdapter.FeedbacksHolder> {

    public FeedbacksAdapter(@NonNull @NotNull FirestoreRecyclerOptions<Feedback> options) {
        super(options);
    }

    @Override
    protected void onBindViewHolder(@NonNull @NotNull FeedbacksAdapter.FeedbacksHolder holder, int position, @NonNull @NotNull Feedback model) {
        holder.user_name.setText(model.getUser_name());
        holder.user_feedback.setText(model.getFeedback());
    }

    @NonNull
    @NotNull
    @Override
    public FeedbacksHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.feedback_cardview, parent, false);

        return new FeedbacksHolder(view);
    }

    public class FeedbacksHolder extends RecyclerView.ViewHolder {

        public TextView user_name;
        public TextView user_feedback;

        public FeedbacksHolder(@NonNull @NotNull View itemView) {
            super(itemView);
            user_name = itemView.findViewById(R.id.user_name);
            user_feedback = itemView.findViewById(R.id.user_feedback);
        }
    }
}
