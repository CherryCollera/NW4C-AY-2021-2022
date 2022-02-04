<?php

session_start();
if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}
// unset($_SESSION["timestamp"]);

// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="Stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="userhome.css"/>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="userprofile.css"/>
    <link rel="stylesheet" type="text/css" href="sellerprofile.css"/>
    <link rel="stylesheet" type="text/css" href="sellerFeedback.css"/>
</head>
<body>
<nav id="navigation" >
        <div onclick='showD()'  class='backBtn'><i class="fas fa-angle-left iconBack"></i> 
         Back</div>
        <img  title='Home'  class='navUL' onclick="window.location.href='userhome.php'" style='cursor:pointer' src='BMCP.png' class='userAdmtxt' alt='log'/>
        <ul id="log">
            <li title='Profile' ><a class='regh' style="padding:4.5px 25px" href="userProfileAct.php"><?php echo"Welcome " . $_SESSION['name'] ?><i class="fas fa-user-tie iconAdmin"></i></a></li>
            <li title='Log-out' ><a class='logh'href="userlogout.php">Log-out</a></li>
        </ul>
    </nav>
    <div class='profile_div'>

    </div>
</body>
<script>

function showD(){
    window.location.href='product-store.php';
}
</script>
</html>