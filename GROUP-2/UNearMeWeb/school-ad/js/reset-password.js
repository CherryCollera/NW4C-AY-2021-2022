$(document).ready(function(){
    $('#reminder').hide();


    const auth = firebase.auth();
    
    $('#reset').on('click', function(){

        var email = $('#email').val();

        if (email != "") {
            // var actionCodeSettings = {
            //     // After password reset, the user will be give the ability to go back
            //     // to this page.
            //     url: 'https://www.facebook.com/',
            //     handleCodeInApp: false
            //   };

            auth.sendPasswordResetEmail(email)
            .then(function(){
                $('#reset').prop('disabled', true);
                $('#reminder').show();
                var seconds = 29;
                var timer = setInterval(() => {
                    $('#seconds').html(seconds + "s");
                    seconds--
                    if(seconds < 0){
                        clearInterval(timer);
                        $('#seconds').html("");
                        $('#reset').prop('disabled', false);
                        $('#reset').text('Send Again');
                    }
                }, 1000);

            })
            .catch(function(error){
                alert(error.message);
            })

        } else {
            alert('Please enter your email')
        }
    })

    $('#gotoHome').on('click', function(){
        window.location.assign("../");
    })

})