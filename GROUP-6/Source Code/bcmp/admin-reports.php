<?php

include 'config.php';

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
    <link rel="stylesheet" type="text/css" href="style.css"/>
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
        <li><a class='logh' href="sellerrequest.php">Register Requests</a></li>
        <li><a class='regh'href="adminlogout.php">Logout</a></li>
        </ul>
    </nav>
    
    <p class='reTitle'>Reported Accounts</p>
<style>
.text_div{
    width:97%;
}
</style>
    <?php
  $connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
    $sql = "SELECT * FROM seller_report";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_array($result)){
            $sq = "SELECT * FROM seller Where id = '".$row["seller_id"]."' LIMIT 1";
            $resu = mysqli_query($connection, $sq);
            if (mysqli_num_rows($resu)> 0){
            while($seller = mysqli_fetch_array($resu)){
                $s = "SELECT * FROM users Where id = '".$row["reporter_id"]."' LIMIT 1";
                $res = mysqli_query($connection, $s);
                if (mysqli_num_rows($res)> 0){
                while($reporter = mysqli_fetch_array($res)){


            echo '<div class="sellereq">
            <div class="imgBtnReq">
            <img src="'. $row["report_file"].'" class="imgReg" alt="asdasd" />
            </div>
            <div class="text-div text_div">
            <p class="reqLabel">Reported Name: </p>
            <p class="reqValue">'. $seller["owner_name"].'</p>
            <p class="reqLabel">Reporter Name: </p>
            <p class="reqValue">'. $reporter["name"].'</p>
            <p class="reqLabel">Case of: </p>
            <p class="reqValue">'. $row["report_title"].'</p>
            <p class="reqLabel">Supporting Testimony: </p>
            <p class="reqValue">'. $row["report_desc"].'</p>
            </div>
           </div>';



                }
            }
                }
            }
        }
    }
    if ($result -> num_rows == 0){
        echo "<p style='color:white; text-align: center; transform:translate(0%, 550%);'>There are no reports.</p>";
 
    }


//     if(isset($_POST['accept'])){
//         $result = mysqli_query($connection, $sql);
//         $sql = "SELECT * FROM requestaccounts";
//         $row = mysqli_fetch_array($result);
//         $brandname = $row['brandname'];
//         $ownername = $row['ownername'];
//         $password = $row['password'];
//         $email = $row['email'];
//         $cnumber = $row['cnumber'];
        
//         if ($email == $row['email']){
//             $sql = "SELECT * FROM requestaccounts WHERE email='$email'";
//             $result = mysqli_query($connection, $sql);
//             if ($result -> num_rows > 0){
//                 $sql = "INSERT INTO seller (brand_name, owner_name, password, email, cnumber)
//                     VALUES ('$brandname', '$ownername', '$password', '$email', '$cnumber')";
//                 $result = mysqli_query($connection, $sql);
//                 if ($result){
//                     echo "<script>alert('Account has been accepted.')</script>";
//                     $sql = "DELETE FROM requestaccounts WHERE email = '$email' AND password='$password'";
//                     $result = mysqli_query($connection, $sql);
//                     header("Refresh:0");
//                 } else {
//                     echo "<script>alert('Something Went Wrong.')</script>";
//                 }
//             } else {
//                 echo "<script>alert('Unknown Error.')</script>";
//             }  
//         } else {
//             echo "<script>alert('Password Not Matched.')</script>";
        
//     }
//     }

//     if(isset($_POST['reject'])){
//         $result = mysqli_query($connection, $sql);
//         $sql = "SELECT * FROM requestaccounts";
//         $row = mysqli_fetch_array($result);
//         $brandname = $row['brandname'];
//         $ownername = $row['ownername'];
//         $password = $row['password'];
//         $email = $row['email'];
//         $cnumber = $row['cnumber'];
        
//         if ($email == $row['email']){
//             $sql = "SELECT * FROM requestaccounts WHERE email='$email'";
//             $result = mysqli_query($connection, $sql);
//             if ($result -> num_rows > 0){
//                 $sql = "DELETE FROM requestaccounts WHERE email = '$email' AND password='$password'";
//                 $result = mysqli_query($connection, $sql);
//                 if ($result){
//                     echo "<script>alert('Account has been rejected.')</script>";
//                     header("Refresh:0");
//                 } else {
//                     echo "<script>alert('Something Went Wrong.')</script>";
//                 }
//             } else {
//                 echo "<script>alert('Unknown Error.')</script>";
//             }  
//         } else {
//             echo "<script>alert('Error.')</script>";
//     }
//     }
// mysqli_close($connection);
?>

</body>
</html>