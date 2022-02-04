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
    <title>About</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css"/>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
</head>
<style>
    h1{
        color: white;
        text-align: center;
        margin-top: 50px;
    }
    p{
        color: white;
        text-align:center;
    }
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
    
    <h1>About</h1>
    <p>Bataan Clothing Management Portal is a website created specially for promoting and selling
        local clothing brands.
    </p>
    <p>
        With this web portal, business owners can register to the system by contacting the admin of this website.
</p>
<p>
    For more details, kindly contact the admin to know how to register as a seller in the system.
</p>


            

  
    



    
</body>
</html>