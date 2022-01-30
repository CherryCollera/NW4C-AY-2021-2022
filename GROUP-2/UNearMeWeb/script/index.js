$(document).ready(function () {
    $(".loader").hide();

    // Global Variables
    const auth = firebase.auth();
    const db = firebase.firestore();
    const storage =  firebase.storage();
    var user;

    $('#register-form').on('submit', function(e){
        e.preventDefault();
        $(".progress").fadeIn()
        $("#register-btn").prop('disabled', true)
        create_account();
    
    })
    function create_account() {
        var email_input = $('#register-email').val();
        var password_input = $('#register-password').val();
    
        auth.createUserWithEmailAndPassword(email_input, password_input)
        .then(() =>{
            new_request();
        })
        .catch(function (error) {
            window.alert("Error : " + error.message);
            $("#register-btn").prop('disabled', false)
        })
    }
    
    function new_request() {
        var documentV = document.getElementById('register-document').files[0];
        // var dateRequested = ;
        
        var storageRef = storage.ref('requests/' + documentV.name);
        var task = storageRef.put(documentV);
        task.on('state_changed',
        (snapshot) => {
            var progress = parseInt((snapshot.bytesTransferred / snapshot.totalBytes) * 100);
            $(".progress-bar").css('width', progress + '%')
            console.log(progress);
        },
        (error) => {
            console.log(error);
        },
        () => {
            $(".loader").fadeIn()
            // Handle successful uploads on complete
            // For instance, get the download URL: https://firebasestorage.googleapis.com/...
            task.snapshot.ref.getDownloadURL().then((downloadURL) => {
                // Save School Info
                db.collection('school_admin').doc(auth.currentUser.uid).set(
                    {
                        name: $('#register-name').val(),
                        email: $('#register-email').val(),
                        province: $('#register-province').val(),
                        school_name: $('#register-school-name').val(),
                        document: downloadURL,
                        status: "pending",
                        date_requested: firebase.firestore.FieldValue.serverTimestamp()
                    }
                ).then(() => {
                    send_verification();
                })
                .catch(function (error) {
                    window.alert("Error : " + error.message);
                })
                
            
            });
                
                
        })
    
    }
    function send_verification() {
        auth.currentUser.sendEmailVerification()
        .then(() => {
            window.location.assign('./school-ad/verify-email.html')
        })
        .catch(function (error) {
            window.alert("Error : " + error.message);
        })
    }

    $('#show-hide-password').on('click', function(){
        
        if($('#login-password').attr('type') === 'password'){
            $(this).find($(".far")).toggleClass('fa-eye-slash').toggleClass('fa-eye');
            $('#login-password').attr('type', 'text');
        } else {
            $(this).find($(".far")).toggleClass('fa-eye').toggleClass('fa-eye-slash');
            $('#login-password').attr('type', 'password');
        }
    })

    $('#login-btn').on('click', function(){
        $(".loader").fadeIn()
        var email_input = $('#login-email').val();
        var password_input = $('#login-password').val();
    
        auth.signInWithEmailAndPassword(email_input, password_input)
        .then((userCredential) => {
            // Signed in
             user = userCredential.user.uid;
            // window.location.assign("../school-ad/home.html");


            db.collection('super_admin').doc(user).get()
            .then(super_admin =>{
                if (super_admin.exists) {
                    window.location.assign("../super-ad/home.html");
                } else {
                    
                    db.collection('school_admin').doc(user).get()
                    .then(school_admin =>{
                        if (school_admin.exists) {
                            window.location.assign("../school-ad/home.html");
                        } else {
                            $(".loader").hide();
                            $('#err-msg').text('Unable to log in!');
                        }
                    }).catch(function (error) {
                        $(".loader").fadeOut()
                        window.alert("Error : " + error.message);
                    })
                }
            })
            .catch(function (error) {
                $(".loader").fadeOut()
                window.alert("Error : " + error.message);
            })
          
    
          // ...
        })
        .catch((error) => {
            // alert(error.message)
            $(".loader").hide()
          $('#err-msg').text('Wrong Email or Password')
        });
    })

    $('input').on('focus', function () {
        $('#err-msg').text('')
    })


    $(document).on('click', '.nav-item', function(){
        $(this).addClass('active').siblings().removeClass('active')

    })
});










// var loginBtn = document.querySelector('#login-btn');

// loginBtn.addEventListener('click', e=>{
//     loginSuperAdmin();

// });

function loginSuperAdmin() {

    var email_input = document.getElementById('login-email').value;
    var password_input = document.getElementById('login-password').value;

    auth.signInWithEmailAndPassword(email_input, password_input)
    .then((userCredential) => {
        // Signed in
        var user = userCredential.user;

        db.collection('super_admin').doc(user.uid).get()
        .then(super_admin =>{
            if (super_admin.exists) {
                window.location.assign("../super-ad");
            }
        })
        .catch(function (error) {
            window.alert("Error : " + error.message);
        })
      

      // ...
    })
    .catch((error) => {
      
      alert(error.message);
    });
}
