<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: log-in.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" type="text/css" href="Stylesheet.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
</head>
<style>
    </style>
<body>
   <nav id="navigation" >
       <p class='userAdmtxt'><?php echo"Welcome " . $_SESSION['username'] ?><i class="fas fa-user-tie iconAdmin"></i></p>
        <ul class='navUL'>
        <li class='navLI'><a class="navA" href="adminhome.php">Home</a></li>
            <li class='navLI'><a class="navA" href="adminabout.php">About</a></li>
            <li class='navLI'><a class="navA" href="admin-reports.php">Reports</a></li>
        </ul>
        </ul>
        <ul id="log">
        <li><a class='regh' href="sellerrequest.php">Register Requests</a></li>
        <li><a class='logh'href="adminlogout.php">Logout</a></li>
        </ul>
    </nav>
    
<div class="collect_wrapper">
    <div class="slider">
        <div class="slides">
            <input type="radio" name="radio-btn" id="radio1">
            <input type="radio" name="radio-btn" id="radio2">

            <div class="slide first">
                <img src="nullify.jpg" alt="">
            </div>
            <div class="slide">
                <img src="halfway.jpg" alt="">
            </div>

            

            <div class="navigation-auto">
                <div class="auto-btn1"></div>
                <div class="auto-btn2"></div>
            </div>

        </div>
            <div class="navigation-manual">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
            </div>
    </div>

    <script type="text/javascript">
    var counter = 1;
    setInterval(function(){
        document.getElementById('radio'+ counter).checked = true;
        counter++;
        if(counter > 2){
            counter = 1;
        }
    }, 5000);
    </script>

    <div class="nullify">
        <img src="nullifybrand1.jpg" alt="">    
        <button class="nullbtn">Nullify Collection</button>
    </div>
    <div class="nullsample">
        <div class="nsample">
            <img src="nullifysample.jpg" width="100%">
        </div>
        <div class="nsample">
            <img src="nullifysample2.jpg" width="100%">
        </div>
    </div>

    <div class="halfwaycrooks">
        <img src="halfway.jpg" alt="">    
        <button class="halfwaybtn">Halfway Crooks Collection</button>
    </div>
    <div class="halfwaysample">
        <div class="hsample">
            <img src="halfwaysample.jpg" width="100%" height="460px">
        </div>
        <div class="hsample">
            <img src="halfwaysample2.jpg" width="100%">
        </div>
    </div>
    </div>
</body>
</html>