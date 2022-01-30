package com.example.unearme;

public class Questions {
    String Question;
    String op1;
    String op2;


    public Questions(){

    }

    public Questions(String question, String op1, String op2) {
        Question = question;
        this.op1 = op1;
        this.op2 = op2;

    }

    public String getQuestion() {
        return Question;
    }

    public void setQuestion(String question) {
        Question = question;
    }

    public String getOp1() {
        return op1;
    }

    public void setOp1(String op1) {
        this.op1 = op1;
    }

    public String getOp2() {
        return op2;
    }

    public void setOp2(String op2) {
        this.op2 = op2;
    }



}