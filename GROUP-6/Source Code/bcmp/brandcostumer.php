<?php
session_start();

if(!isset($_SESSION['brandname'])){
    header("Location: log-in.php");
}
$_SESSION['brand'] = $_POST['brandName'];
header("Location: seller.php");
?>