<?php

session_start();

if(!isset($_SESSION['brandname'])){
    header("Location: log-in.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
</head>
<style>
    </style>
<body>
    <div id="wrapper">
        <div id="banner">
   </div>   
   
   <nav id="navigation" >
        <ul id="nav">
            <li><a href="sellerhome.php">Home</a></li>
            <li><a href="sellerabout.php">About</a></li>
            <li><a href="sellerproducts.php">Products</a></li>
        </ul>
        <ul id="log">
            <li><?php echo "Welcome " . $_SESSION['brandname'];?></li>
            <li><a href="sellerlogout.php">Logout</a></li>
        </ul>
    </nav>
    


    
</body>
</html>