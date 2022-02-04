<?php
session_start();

if(!isset($_SESSION['brandname'])){
    header("Location: log-in.php");
}
$_SESSION['prodID'] = $_POST['productIDtxt'];
header("Location: productdetails.php");
?>