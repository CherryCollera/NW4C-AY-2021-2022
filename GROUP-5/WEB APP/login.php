<?php
    require_once "init.php";


    //if (isset($_SESSION["loggedIn"])) {
        //header("location: /");
    //}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
    <div class="form-container">
        <div class="signin">

            <div class="signin-form">
                <img src="img/logo1.png" alt="logo" height="150px" width="150px">
                <h2 class="title">Sign in</h2>
                <div class="input-field">
                    <i class="fa-user"></i>
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="input-field">
                    <i class="fa-user"></i>
                    <input type="password" name="password" placeholder="Password">
                </div>
                <button onclick="login()" class="btn solid">Login</button>
            </div>
        </div>
    </div>

    <div class="panel-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>Bataan iResponse</h3>
                <p style="text-align: justify;">Barangay Quick Response and Incident Reporting is intended to help the barangay official in improving the response time of the barangay in emergency situations. This would allow the residents to easily report any incident, obtain a response from barangay officials, and provide comprehensive reports of the incident.</p>
            </div>
            <img src="img/login1.svg" class="image" alt="">
        </div>
        
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>

    <script>

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyDOUEdVLNAgqeJAdy9FlEVY5dZpidT-PEQ",
            authDomain: "ibataanresponse.firebaseapp.com",
            projectId: "ibataanresponse",
            storageBucket: "ibataanresponse.appspot.com",
            messagingSenderId: "1016927101773",
            appId: "1:1016927101773:web:eb127f3df4a4b5d2764d04",
            measurementId: "G-L9GJECBHN8"
        };

        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);

        function login() {
            const email = document.querySelector("input[name='username']").value,
                password = document.querySelector("input[name='password']").value;

            firebase.auth().signInWithEmailAndPassword(email, password)
                .then((userCredential) => {
                    const user = userCredential.user;

                    if (user.email.trim() == "pangilinanangel20@gmail.com") {
                        sessionStorage.setItem("user", user);

                        axios({
                            method: 'get',
                            url: 'loginProcess.php?loggedIn=true'
                        }).then((data) => {
                            console.log(data);
                        });

                        window.location.href = "index.php";
                    } else {
                        alert("You are not allowed!");
                    }
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                });
        }
    </script>
</div> 
</body>
</html>