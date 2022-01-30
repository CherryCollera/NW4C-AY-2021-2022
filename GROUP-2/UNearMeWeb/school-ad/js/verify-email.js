window.onload = countdown();
        

        const auth = firebase.auth();
        
        auth.onAuthStateChanged(function(user) {
            // if admin is loggedIn 
            if(user){
                if(!user.emailVerified){
                    var interval = setInterval(() => {
                        auth.currentUser.reload().then(ok => {
                            if (auth.currentUser.emailVerified) {
                                clearInterval(interval);
                                //updateEmail();
                                window.location.assign("../school-ad");
                            }
                        })
                    }, 1000);
                } else {
                    window.location.assign("../");
                }
            } else {
                window.location.assign("../");
            }
        });

        $('#resend-verification').on('click', function(){
            countdown();
            auth.currentUser.reload().then(ok => {
                if (!auth.currentUser.emailVerified) {
                    auth.currentUser.sendEmailVerification().catch(function (error) {
                        window.alert("Error : " + error.message);
                    })
                }
            })
        })
        var countdownContainer = $('#countdown-container');

        function countdown() {
            $('#resend-verification').prop('disabled', true);
            var seconds = 60;
            var timer = setInterval(() => {
                $('#countdown-container').html(seconds + "s");
                seconds--;
                if(seconds < 0){
                   clearInterval(timer);
                   $('#countdown-container').html('');
                   $('#resend-verification').prop('disabled', false);
                }
           }, 1000);
        }


        // function updateEmail() {
        //     firebase.firestore().collection('school_admin').doc(auth.currentUser.uid).update({
        //         email_verified: auth.currentUser.emailVerified
        //     }).catch(function (err) {
        //         console.log(err);
        //     })
        // }

        $('#gotoHome').on('click', function(){
        window.location.assign("../");
    })