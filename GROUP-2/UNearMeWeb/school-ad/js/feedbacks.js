$(document).ready(function(){

    const db = firebase.firestore();
    const auth = firebase.auth();
    var sid,uid;
    var feedback_id;
    var badwords = /tanga|bobo|pota|puta|obob|gago|ogag|tangna|tang na|tangina|tang|ina|inamo|ina mo|siraulo|sira ulo|b0b0|0b0b|tnga|fuck|fuck you|fuckyou|fvck|pakyu|bullshit|shit|damn|piss off|dick|ass|asshole|bitch|bastard|suck|pussy|sex|hayop|potang ina|putang ina|potangina|putangina|tae|titi/gi

    // Firebase Authentication
    auth.onAuthStateChanged(function(user) {
        if(user){
            // Check if School ID is existing
            uid = user.uid;
            getSchoolID(user.uid);
            account(user.uid)
            $('.email-nav').text(`${user.email}`);
            
        } else {
            // uid = null;
            window.location.assign("/index.html");
        }
    });
    function getSchoolID(uid){
        db.collection('school_admin').doc(uid).onSnapshot( function(snapshot){
            if (snapshot.data().school_id) {
                
                sid = snapshot.data().school_id;

                db.collection('schools').doc(sid).collection('feedbacks').orderBy('time', 'asc').onSnapshot(function (snapshot) {
                    $('.feedbacks-container').html('');
                    if(!snapshot.empty){
                        snapshot.forEach(function (taskValue) {
                            var date = taskValue.data().time.seconds
    
                            var newDate = new Date(date * 1000)
                            var m,d,y, formattedDate;
    
                            d = newDate.getDate()
                            m = newDate.getMonth()
                            y = newDate.getFullYear()
    
                            formattedDate = m+1+'/'+d+'/'+y
    
                            var name = taskValue.data().user_name;
                            if(!taskValue.data().display_name){
                                name = name.replaceAll(/(?<=\w{1,})\w/g, '*');
                            }
                            let checkWords = taskValue.data().feedback.replaceAll(badwords,"****")

                             //var y = d.getFullYear();
                            $('.feedbacks-container').append(`
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="card-title mb-2 text-muted">${name}</h6>
                                            <button type="button" class="btn btn-danger" id="${taskValue.id}" value="${taskValue.id}">Delete</button>
                                           
                                        </div>
                                        <h6 class="card-title mb-2 text-muted">${formattedDate}</h6>
                                        <h4 class="card-text">${checkWords}</h4>
                                        
                                    </div>
                                </div>
                                `);
                               
                                $("#"+taskValue.id).on('click', function(){
                                    feedback_id = $(this).val();
                                    $('#deleteFeedbackModal').modal('show');
                                        
                                })
                               
                        })
                    } else {
                        $('.feedbacks-container').append( `
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"> No Data Found</h5>
                                </div>
                            </div>
                            `);
                    }
                    
                    
                })
            } else {
                window.location.assign("index.html");
            }
        })
    }


    $('#yesDelete').on('click',function(){
        $('#deleteFeedbackModal').modal('hide');
        db.collection('schools').doc(sid).collection('feedbacks').doc(feedback_id).delete();
    //   console.log(feedback_id);  
    })
  

    $('#logout').on('click', function () {
        auth.signOut().then(() => {
            // Sign-out successful.
          }).catch((error) => {
            // An error happened.
          });
    })




    $('#account').on('click', function(){
       
        $('#accountModal').modal('show');
       
    })

    function account(uid){
        db.collection('school_admin').doc(uid).onSnapshot(function(snapshot){
            $('#name').val(snapshot.data().name)
            $('#email').val(snapshot.data().email)
        })
    }

    $('#updateAccount').on('submit', function(e){
        e.preventDefault();
        auth.signInWithEmailAndPassword(auth.currentUser.email, $('#password').val()).then( function(userCredential){
            userCredential.user.updateEmail($('#email').val())
            db.collection("school_admin").doc(uid).update({
                name: $('#name').val(),
                email: $('#email').val()
            })
            $('#accountModal').modal('hide');
            $('#password').val('')
        })
    })

})

