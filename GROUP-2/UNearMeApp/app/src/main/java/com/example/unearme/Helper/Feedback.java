package com.example.unearme.Helper;

import com.google.firebase.firestore.ServerTimestamp;

import java.util.Date;

public class Feedback {

    private Boolean display_name;
    private String user_id;
    private String user_name;
    private String feedback;
    private @ServerTimestamp Date time;

    public Date getTime() {
        return time;
    }

    public Feedback() {
    }

    public String getUser_id() {
        return user_id;
    }

    public String getUser_name() {
        return user_name;
    }

    public String getFeedback() {
        return feedback;
    }

    public Boolean getDisplay_name() {
        return display_name;
    }
}
