package com.example.unearme.Helper;

import android.os.Parcel;
import android.os.Parcelable;

import com.google.firebase.firestore.GeoPoint;

import java.util.List;

public class SchoolInfo implements Parcelable {

    private String school_name;
    private String school_logo;
    private String school_id;
    private String type;
    private String entrance_exam;
    private String religious_affiliation;
    private String term_structure;
    private String school_year;
    private List<String> requirements;
    private String address;
    private GeoPoint location = null;
    private List<String> programs;
    private Integer bachelors_cost;
    private Integer masters_cost;
    private String email;
    private String website;
    private String municipality;

    Double latitude, longitude;

    public  SchoolInfo(){
        // Required empty public constructor
    }

    protected SchoolInfo(Parcel in) {
        school_name = in.readString();
        school_logo = in.readString();
        school_id = in.readString();
        type = in.readString();
        entrance_exam = in.readString();
        religious_affiliation = in.readString();
        term_structure = in.readString();
        school_year = in.readString();
        requirements = in.createStringArrayList();
        address = in.readString();
        programs = in.createStringArrayList();

        bachelors_cost = in.readInt();
        masters_cost = in.readInt();

        email = in.readString();
        website = in.readString();

        latitude = in.readDouble();
        longitude = in.readDouble();
        location = new GeoPoint(latitude, longitude);
    }

    public String getMunicipality() {
        return municipality;
    }

    public String getSchool_name() {
        return school_name;
    }

    public String getSchool_logo() {
        return school_logo;
    }

    public String getSchool_id() {
        return school_id;
    }

    public String getType() {
        return type;
    }

    public String getEntrance_exam() {
        return entrance_exam;
    }

    public String getReligious_affiliation() {
        return religious_affiliation;
    }

    public String getTerm_structure() {
        return term_structure;
    }

    public String getSchool_year() {
        return school_year;
    }

    public List<String> getRequirements() {
        return requirements;
    }

    public String getAddress() {
        return address;
    }

    public GeoPoint getLocation() {
        return location;
    }

    public List<String> getPrograms() {
        return programs;
    }

    public Integer getBachelors_cost() {
        return bachelors_cost;
    }

    public Integer getMasters_cost() {
        return masters_cost;
    }

    public String getEmail() {
        return email;
    }

    public String getWebsite() {
        return website;
    }

    public Double getLatitude() {
        return latitude;
    }

    public Double getLongitude() {
        return longitude;
    }

    public static final Creator<SchoolInfo> CREATOR = new Creator<SchoolInfo>() {
        @Override
        public SchoolInfo createFromParcel(Parcel in) {
            return new SchoolInfo(in);
        }

        @Override
        public SchoolInfo[] newArray(int size) {
            return new SchoolInfo[size];
        }
    };

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(school_name);
        dest.writeString(school_logo);
        dest.writeString(school_id);
        dest.writeString(type);
        dest.writeString(entrance_exam);
        dest.writeString(religious_affiliation);
        dest.writeString(term_structure);
        dest.writeString(school_year);
        dest.writeStringList(requirements);
        dest.writeString(address);
        dest.writeStringList(programs);

        dest.writeInt(bachelors_cost);
        dest.writeInt(masters_cost);

        dest.writeString(email);
        dest.writeString(website);


        latitude = getLocation().getLatitude();
        longitude = getLocation().getLongitude();
        dest.writeDouble(location.getLatitude());
        dest.writeDouble(location.getLongitude());
    }
}
