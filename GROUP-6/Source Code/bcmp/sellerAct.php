<?php
session_start();

if(!isset($_SESSION['seller_name'])){
    header("Location: log-in.php");
}


if(isset($_POST['DetaBuyBtn'])){
    $_SESSION['order_id'] = $_POST['orderID'];
    $_SESSION['product_id'] = $_POST['DetaBuyBtn'];
    echo"<script>window.location.href='seller-order.php' </script>";
  }

?>