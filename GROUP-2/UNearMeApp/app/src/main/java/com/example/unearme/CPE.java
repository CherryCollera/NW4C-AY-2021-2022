package com.example.unearme;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Random;

public class CPE extends AppCompatActivity {

    TextView tvquestion, tvquestionno, result;
    Button btnnext, finish;
    EditText choices;
    RadioGroup grpradio;
    RadioButton op1, op2;
    private Questions question = new Questions();
    Random random;
    //private  int questionlength = question.questions.length;
    int qCounter = 1;
    int conter = 0;
    int index;
    int A=0, B=0, C=0, D=0, E=0, F=0, G=0, H=0, I=0, J=0, K=0, L=0, M=0, N=0, O=0, P=0, Q=0, r=0;
    ArrayList<Questions> INTEREST = new ArrayList<>();
    String program, description;
    boolean answered;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cpe);

        random = new Random();
        tvquestion = (TextView)findViewById(R.id.question);
        tvquestionno = (TextView)findViewById(R.id.tvcounter);
        btnnext = (Button)findViewById(R.id.next);
        grpradio = (RadioGroup) findViewById(R.id.radio);
        op1 = (RadioButton)findViewById(R.id.op1);
        op2 = (RadioButton)findViewById(R.id.op2);
        choices = (EditText)findViewById(R.id.choice);
        finish = (Button)findViewById(R.id.finish);

        //NextQuestion(random.nextInt(questionlength));
        finish.setVisibility(View.INVISIBLE);
        int radioID = grpradio.getCheckedRadioButtonId();
        //choices.setVisibility(View.INVISIBLE);




        INTEREST.add(new Questions("A. Operate a printing press\n\n" +
                "B .Study the causes of earthquakes", "A", "B"));
        INTEREST.add(new Questions("C. Plant and harvest crops\n\n" +
                "R .Replace a car window and fender", "C", "R"));
        INTEREST.add(new Questions("E. Analyze reports and records\n\n" +
                "F .Operate a machine", "E", "F"));
        INTEREST.add(new Questions("G. Work in an office\n\n" +
                "H. Answer customer questions", "G", "H"));
        INTEREST.add(new Questions("D. Write reports\n\n" +
                "J. Help former prison inmates find work", "D", "J"));
        INTEREST.add(new Questions("L. Design a freeway\n\n" +
                "M. Plan educational lessons", "L", "M"));
        INTEREST.add(new Questions("N. Balance a checkbook\n\n" +
                "O. Take an X-ray", "N", "O"));
        INTEREST.add(new Questions("P. Write a computer program\n\n" +
                "Q. Train animals", "P", "Q"));
        INTEREST.add(new Questions("C. Be in charge of replanting forests\n\n" +
                "A. Act in a TV show or movie", "C", "A"));
        INTEREST.add(new Questions("D. Solve a burglary\n\n" +
                "F. Check products for quality", "D", "F"));
        INTEREST.add(new Questions("E. Build an airport\n\n" +
                "G. Keep company business records", "E", "G"));
        INTEREST.add(new Questions( "A. Choreograph a dance\n\n" +
                "K. Lobby or show support for a cause", "A", "K"));
        INTEREST.add(new Questions("F. Put together small tool\n\n" +
                "P. Design a website", "F", "P"));
        INTEREST.add(new Questions("M. Tutor students \n\n" +
                "Q. Work at a zoo", "M", "Q"));
        INTEREST.add(new Questions("J. Take care of children\n\n" +
                "O. Plan special diets", "J", "O"));
        INTEREST.add(new Questions("H. Sell clothes\n\n" +
                "E. Work with your hands", "H", "E"));
        INTEREST.add(new Questions("I. Work at an amusement park\n\n" +
                "N. Sell insurance", "I", "N"));
        INTEREST.add(new Questions("I. Learn about ethnic groups\n\n" +
                "P. Manage an information system", "I", "P"));
        INTEREST.add(new Questions("N. Appraise the value of a house\n\n" +
                "M. File books at the library", "N", "M"));
        INTEREST.add(new Questions("M. Grade papers\n\n" +
                "R. Operate a train", "M", "R"));
        INTEREST.add(new Questions("L. Order building supplies\n\n" +
                "E. Paint motors", "L", "E"));
        INTEREST.add(new Questions("P. Develop new computer games\n\n" +
                "H. Buy merchandise for a store", "P", "H"));
        INTEREST.add(new Questions("K. Work to get someone elected\n\n" +
                "C. Identify plants in a forest", "K", "C"));
        INTEREST.add(new Questions("D. Guard inmates in a prison\n\n" +
                "L. Read blueprints ", "D", "L"));
        INTEREST.add(new Questions("H. Line up concerts for a band\n\n" +
                "K. Ask people survey questions", "H", "K"));
        INTEREST.add(new Questions("E. Manage a factory\n\n" +
                "O. Work as a nurse in a hospital", "E", "O"));
        INTEREST.add(new Questions("A. Paint a portrait\n\n" +
                "K. Testify before Congress", "A", "K"));
        INTEREST.add(new Questions("B. Work with a microscope\n\n" +
                "I. Schedule tee times at a golf course", "B", "I"));
        INTEREST.add(new Questions("C. Classify plants\n\n" +
                "O. Transcribe medical records", "C", "O"));
        INTEREST.add(new Questions("E. Make three-dimensional items\n\n" +
                "D. Analyze handwriting", "E", "D"));
        INTEREST.add(new Questions("B. Design indoor sprinkler systems\n\n" +
                "F. Run a factory sewing machine", "B", "F"));
        INTEREST.add(new Questions("G. Develop personnel policies\n\n" +
                "Q. Train racehorses", "G", "Q"));
        INTEREST.add(new Questions("D. Guard an office building\n\n" +
                "H. Run a department store", "D", "H"));
        INTEREST.add(new Questions("A. Write for a newspaper\n\n" +
                "G. Use a calculator", "A", "G"));
        INTEREST.add(new Questions("O. Help people at a mental health clinic\n\n" +
                "L. Remodel old houses", "O", "L"));
        INTEREST.add(new Questions("M. Care for young children\n\n" +
                "D. Locate a missing person", "M", "D"));
        INTEREST.add(new Questions("N. Plan estate disbursements/payments\n\n" +
                "P. Enter data", "N", "P"));
        INTEREST.add(new Questions("A. Design a book cover\n\n" +
                "E. Build toys with written instructions", "A", "E"));
        INTEREST.add(new Questions("B. Figure out why someone is sick\n\n" +
                "R. Fly an airplane", "B", "R"));
        INTEREST.add(new Questions( "C. Learn how things grow and stay alive\n\n" +
                "H. Sell cars", "C", "H"));
        INTEREST.add(new Questions( "I. Work as a restaurant host or hostess\n\n" +
                "D. Fight fires", "I", "D"));
        INTEREST.add(new Questions( "G. Keep payroll records for a company\n\n" +
                "J. Work in a nursing home ", "G", "J"));
        INTEREST.add(new Questions("G. Hire new staff\n\n" +
                "O. Run ventilators/breathing machines", "G", "O"));
        INTEREST.add(new Questions( "R. Drive a taxi\n\n" +
                "A. Broadcast the news", "R", "A"));
        INTEREST.add(new Questions("K. Audit taxes for the government\n\n" +
                "B. Sort and date dinosaur bones ", "K", "B"));
        INTEREST.add(new Questions("O. Give shots\n\n" +
                "C. Design landscaping", "O", "C"));
        INTEREST.add(new Questions("P. Give tech support to computer users\n\n" +
                "D. Work in a courtroom", "P", "D"));
        INTEREST.add(new Questions( "Q. Care for injured animals\n\n" +
                "I. Serve meals to customers", "Q", "I"));
        INTEREST.add(new Questions("F. Install rivets\n\n" +
                "Q. Raise worms", "F", "Q"));
        INTEREST.add(new Questions("N. Balance accounts\n\n" +
                "M. Develop learning games", "N", "M"));
        INTEREST.add(new Questions("J. Read to sick people\n\n" +
                "P. Repair computers", "J", "P"));
        INTEREST.add(new Questions("F. Compare sizes and shapes of objects\n\n" +
                "Q. Fish", "F", "Q"));
        INTEREST.add(new Questions("R. Repair bicycles\n\n" +
                "K. Deliver mail", "R", "K"));
        INTEREST.add(new Questions("M. Teach Special Education\n\n" +
                "P. Set up a tracking system", "M", "P"));
        INTEREST.add(new Questions("G. Manage a store\n\n" +
                "H. Advertise goods and services", "G", "H"));
        INTEREST.add(new Questions( "R. Distribute supplies to dentists\n\n" +
                "I. Compete in a sports event", "R", "I"));
        INTEREST.add(new Questions("I. Check guests into a hotel\n\n" +
                "M. Teach adults to read", "I", "M"));
        INTEREST.add(new Questions("L. Follow step-by-step instructions\n\n" +
                "N. Collect past due bills", "L", "N"));
        INTEREST.add(new Questions("L. Build kitchen cabinets\n\n" +
                "N. Refinance a mortgage", "L", "N"));
        INTEREST.add(new Questions("A. Sing in a concert\n\n" +
                "R  Direct the takeoff/landing of planes", "A", "R"));
        INTEREST.add(new Questions("G. Operate a cash register\n\n" +
                "B. Collect rocks", "G", "B"));
        INTEREST.add(new Questions("G. Start a business\n\n" +
                "L. Draft a blueprint", "G", "L"));
        INTEREST.add(new Questions("M. Assess student progress\n\n" +
                "L. Design an airplane", "M", "L"));
        INTEREST.add(new Questions("O. Wrap a sprained ankle\n\n" +
                "I. Guide an international tour group", "O", "I"));
        INTEREST.add(new Questions("P. Solve technical problems\n\n" +
                "J. Provide spiritual guidance to others", "P", "J"));
        INTEREST.add(new Questions( "Q. Manage a veterinary clinic\n\n" +
                "K. Lead others", "Q", "K"));
        INTEREST.add(new Questions("E. Operate heavy equipment\n\n" +
                "Q. Manage a fish hatchery", "E", "Q"));
        INTEREST.add(new Questions("P. Write a computer program\n\n" +
                "Q. Train animals", "P", "Q"));
        INTEREST.add(new Questions( "F. Assemble cars\n\n" +
                "K. Protect our borders", "F", "K"));
        INTEREST.add(new Questions("A. Play an instrument\n\n" +
                "J. Plan activities for adult day care", "A", "J"));
        INTEREST.add(new Questions("C. Research soybean use in paint\n\n" +
                "J. Provide consumer information", "C", "J"));
        INTEREST.add(new Questions("D. Guard money in an armored car\n\n" +
                "B. Study human behavior", "D", "B"));
        INTEREST.add(new Questions("E. Fix a television set\n\n" +
                "M. Run a school", "E", "M"));
        INTEREST.add(new Questions("P. Write a computer program\n\n" +
                "Q. Train animals", "P", "Q"));
        INTEREST.add(new Questions( "F. Fix a control panel\n\n" +
                "J. Help friends with personal problems", "F", "J"));
        INTEREST.add(new Questions("C. Oversee a logging crew\n\n" +
                "B. Study weather conditions", "C", "B"));
        INTEREST.add(new Questions("R. Pack boxes at a warehouse\n\n" +
                "A. Teach dancing", "R", "A"));
        INTEREST.add(new Questions( "O. Sterilize surgical instruments\n\n" +
                "B. Study soil conditions", "O", "B"));
        INTEREST.add(new Questions( "N. Play the stock market\n\n" +
                "C. Protect the environment", "N", "C"));
        INTEREST.add(new Questions( "R. Inspect cargo containers\n\n" +
                "F. Work in a cannery", "R", "F"));
        INTEREST.add(new Questions( "I. Coach a school sports team\n\n" +
                "P. Update a website", "I", "P"));
        INTEREST.add(new Questions("Q. Hunt\n\n" +
                "K. Enlist in a branch of the military", "Q", "K"));
        INTEREST.add(new Questions( "H. Sell sporting goods\n\n" +
                "J. Cut and style hair", "H", "J"));
        INTEREST.add(new Questions("B. Experiment to find new metals\n\n" +
                "N. Work in a bank", "B", "N"));
        INTEREST.add(new Questions( "G. Work with computer programs\n\n" +
                "N. Loan money", "G", "N"));
        INTEREST.add(new Questions("L. Hang wallpaper\n\n" +
                "D. Make an arrest", "L", "D"));
        INTEREST.add(new Questions("O. Deliver babies\n\n" +
                "H. Persuade people to buy something", "O", "H"));
        INTEREST.add(new Questions("H. Stock shelves\n\n" +
                "I. Serve concession stand drinks", "H", "I"));



        //interest(conter);

        String l = choices.getText().toString();

        conter = 0;




        btnnext.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                int selectedId = grpradio.getCheckedRadioButtonId();

                if (qCounter <85) {


                    if (selectedId == -1){
                        Toast.makeText(CPE.this,"Please select one from the choices!",Toast.LENGTH_SHORT).show();
                    }
                    else{
                        counter();
                        interest(conter);
                        conter++;
                        qCounter++;
                        tvquestionno.setText(qCounter + "/85");
                        grpradio.clearCheck();
                    }


                }
                else{
                    btnnext.setVisibility(View.INVISIBLE);
                    finish.setVisibility(View.VISIBLE);
                }


            }

        });

        finish.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finishActivity();


            }
        });





    }
    private void counter(){
        int selectedId = grpradio.getCheckedRadioButtonId();
        RadioButton radioButton = findViewById(selectedId);

        switch (radioButton.getText().toString()){
            case "A":
                A++;
//                Toast.makeText(CPE.this,"A = "+String.valueOf(A),Toast.LENGTH_SHORT).show();
                break;
            case "B":
                B++;
//                Toast.makeText(CPE.this,"B = "+String.valueOf(B),Toast.LENGTH_SHORT).show();
                break;
            case "C":
                C++;
                //Toast.makeText(CPE.this,"C = "+String.valueOf(C),Toast.LENGTH_SHORT).show();
                break;
            case "D":
                D++;
                //Toast.makeText(CPE.this,"D = "+String.valueOf(D),Toast.LENGTH_SHORT).show();
                break;
            case "E":
                E++;
                //Toast.makeText(CPE.this,"E = "+String.valueOf(E),Toast.LENGTH_SHORT).show();
                break;
            case "F":
                F++;
                //Toast.makeText(CPE.this,"F = "+String.valueOf(F),Toast.LENGTH_SHORT).show();
                break;
            case "G":
                G++;
                //Toast.makeText(CPE.this,"G = "+String.valueOf(G),Toast.LENGTH_SHORT).show();
                break;
            case "H":
                H++;
                //Toast.makeText(CPE.this,"H = "+String.valueOf(H),Toast.LENGTH_SHORT).show();
                break;
            case "I":
                I++;
                //Toast.makeText(CPE.this,"I = "+String.valueOf(I),Toast.LENGTH_SHORT).show();
                break;
            case "J":
                J++;
                //Toast.makeText(CPE.this,"J = "+String.valueOf(J),Toast.LENGTH_SHORT).show();
                break;
            case "K":
                K++;
                //Toast.makeText(CPE.this,"K = "+String.valueOf(K),Toast.LENGTH_SHORT).show();
                break;
            case "L":
                L++;
                //Toast.makeText(CPE.this,"L = "+String.valueOf(L),Toast.LENGTH_SHORT).show();
                break;
            case "M":
                M++;
                //Toast.makeText(CPE.this,"M = "+String.valueOf(M),Toast.LENGTH_SHORT).show();
                break;
            case "N":
                N++;
                //Toast.makeText(CPE.this,"N = "+String.valueOf(N),Toast.LENGTH_SHORT).show();
                break;
            case "O":
                O++;
                //Toast.makeText(CPE.this,"O = "+String.valueOf(O),Toast.LENGTH_SHORT).show();
                break;
            case "P":
                P++;
                //Toast.makeText(CPE.this,"P = "+String.valueOf(P),Toast.LENGTH_SHORT).show();
                break;
            case "Q":
                Q++;
                //Toast.makeText(CPE.this,"Q = "+String.valueOf(Q),Toast.LENGTH_SHORT).show();
                break;
            case "R":
                r++;
                //Toast.makeText(CPE.this,"R = "+String.valueOf(r),Toast.LENGTH_SHORT).show();
                break;


        }

    }
    public  void  interest(int m){
        Questions q = INTEREST.get(m);
        tvquestion.setText(q.getQuestion());
        op1.setText(q.getOp1());
        op2.setText(q.getOp2());

    }
    public void finishActivity(){
        //Intent intent = new Intent(this, MainActivity2.class);
        //startActivity(intent);
        if (A >= B && A >=C && A >=D && A >=E && A >=F && A >=G && A >=H && A >=I && A >=J && A >=K && A >=L && A >=M && A >=N && A >=O && A >=P && A >=Q && A >=r) {
            program = "Arts, A/V Technology and Communications";
            description = " Interest in creative or performing arts, communication or A/V technology.";
            sendData();
        }

        else if (B >= A && B >=C && B >=D && B >=E && B >=F && B >=G && B >=H && B >=I && B >=J && B >=K && B >=L && B >=M && B >=N && B >=O && B >=P && B >=Q && B >=r) {
            program = "Science, Technology, Engineering and Mathematics";
            description = " Interest in problem-solving, discovering, collecting and analyzing information and applying findings to problems in science, math and engineering.";
            sendData();

        }
        else if (C >= A && C >= B && C >=D && C >=E && C >=F && C >=G && C >=H && C >=I && C >=J && C >=K && C >=L && C >=M && C >=N && C >=O && C >=P && C >=Q && C >=r) {
            program = "Plants, Agriculture and Natural Resources";
            description = "Interest in activities involving plants, usually in an outdoor setting.";
            sendData();
        }

        else if (D >= A && C >= B && D >=C && D >=E && D >=F && D >=G && D >=H && D >=I && D >=J && D >=K && D >=L && D >=M && D >=N && D >=O && D >=P && D >=Q && D >=r) {
            program = "Law, Public Safety, Corrections and Security";
            description = "Interest in judicial, legal and protective services for people and property.";
            sendData();
        }

        else if (E >= A && E >= B && E >=C && E >=D && E >=F && E >=G && E >=H && E >=I && E >=J && E >=K && E >=L && E >=M && E >=N && E >=O && E >=P && E >=Q && E >=r) {
            program = "Mechanical Manufacturing";
            description = "Interest in applying mechanical principles to practical situations using machines, hand tools or techniques.";
            sendData();
        }

        else if (F >= A && F >= B && F >=C && F >=D && F >=E && F >=G && F >=H && F >=I && F >=J && F >=K && F >=L && F >=M && F >=N && F >=O && F >=P && F >=Q && F >=r) {
            program = " Industrial Manufacturing";
            description = "Interest in repetitive, organized activities in a factory or industrial setting.";
            sendData();
        }

        else if (G >= A && G >= B && G >=C && G >=D && G >=E && G >=F && G >=H && G >=I && G >=J && G >=K && G >=L && G >=M && G >=N && G >=O && G >=P && G >=Q && G >=r) {
            program = "Business, Management and Administration";
            description = "Interest in organizing, directing and evaluating business functions.";
            sendData();
        }

        else if (H >= A && H >= B && H >=C && H >=D && H >=E && H >=F && H >=G && H >=I && H >=J && H >=K && H >=L && H >=M && H >=N && H >=O && H >=P && H >=Q && H >=r) {
            program = "Marketing, Sales and Service";
            description = "Interest in bringing others to a point of view through personal persuasion, using sales or promotional techniques.";
            sendData();
        }

        else if (I >= A && I >= B && I >=C && I >=D && I >=E && I >=F && I >=G && I >=H && I >=J && I >=K && I >=L && I >=M && I >=N && I >=O && I >=P && I >=Q && I >=r) {
            program = "Hospitality and Tourism";
            description = "Interest in providing services to others in travel planning and hospitality services in hotels, restaurants and recreation.";
            sendData();
        }

        else if (J >= A && J >= B && J >=C && J >=D && J >=E && J >=F && J >=G && J >=H && J >=I && J >=K && J >=L && J >=M && J >=N && J >=O && J >=P && J >=Q && J >=r) {
            program = "Human Services";
            description = "Interest in helping others with their mental, spiritual, social, physical or career needs.";
            sendData();
        }

        else if (K >= A && K >= B && K >=C && K >=D && K >=E && K >=F && K >=G && K >=H && K >=I && K >=J && K >=L && K >=M && K >=N && K >=O && K >=P && K >=Q && K >=r) {
            program = "Government and Public Administration";
            description = "Interest in performing government functions at the local, state or federal level.";
            sendData();
        }

        else if (L >= A && L >= B && L >=C && L >=D && L >=E && L >=F && L >=G && L >=H && L >=I && L >=J && L >=K && L >=M && L >=N && L >=O && L >=P && L >=Q && L >=r) {
            program = "  Architecture, Design and Construction";
            description = "  Interest in designing, planning, managing, building and maintaining physical structures.";
            sendData();
        }

        else if (M >= A && M >= B && M >=C && M >=D && M >=E && M >=F && M >=G && M >=H && M >=I && M >=J && M >=K && M >=L && M >=N && M >=O && M >=P && M >=Q && M >=r) {
            program = "Education and Training";
            description = "Interest in planning, managing and providing educational services, including support services, library and information services.";
            sendData();
        }

        else if (N >= A && N >= B && N >=C && N >=D && N >=E && N >=F && N >=G && N >=H && N >=I && N >=J && N >=K && N >=L && N >=M && N >=O && N >=P && N >=Q && N >=r) {
            program = "Finance, Banking, Investments and Insurance";
            description = "Interest in financial and investment planning and management, and providing banking and insurance services.";
            sendData();
        }

        else if (O >= A && O >= B && O >=C && O >=D && O >=E && O >=F && O >=G && O >=H && O >=I && O >=J && O >=K && O >=L && O >=M && O >=N && O >=P && O >=Q && O >=r) {
            program = "Finance, Banking, Investments and Insurance";
            description = "Interest in financial and investment planning and management, and providing banking and insurance services.";
            sendData();
        }

        else if (P >= A && P >= B && P >=C && P >=D && P >=E && P >=F && P >=G && P >=H && P >=I && P >=J && P >=K && P >=L && P >=M && P >=N && P >=P && P >=Q && P >=r) {
            program = "Information Technology (IT)";
            description = "Interest in the design, development, support and management of hardware, software, multimedia, systems integration services and technical support.";
            sendData();
        }

        else if (Q >= A && Q >= B && Q >=C && Q >=D && Q >=E && Q >=F && Q >=G && Q >=H && Q >=I && Q >=J && Q >=K && Q >=L && Q >=M && Q >=N && Q >=P && Q >=P && Q >=r) {
            program = "Animals, Agriculture and Natural Resources";
            description = " Interest in activities involving the training, raising, feeding and caring for animals.";
            sendData();
        }

        else if (r >= A && r >= B && r >=C && r >=D && r >=E && r >=F && r >=G && r >=H && r >=I && r >=J && r >=K && r >=L && r >=M && r >=N && r >=P && r >=P && r >=Q) {
            program = "Transportation, Distribution and Logistics";
            description = "Interest in the movement of people, materials and goods by road, pipeline, air, railroad or water.";
            sendData();
        }

        else {

        }
    }

    private void sendData(){
        Intent i = new Intent(CPE.this, Result.class);
        i.putExtra(Result.PROGRAM,program);
        i.putExtra(Result.DESCRIPTION,description);
        startActivity(i);
        finish();
    }
}