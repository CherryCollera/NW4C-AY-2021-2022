<?php
if(isset($_POST['BuyBtn'])){
    echo "<script>alert('Add to Cart failed. Please log in to your account.');</script>";
    echo"<script>window.location.href='log-in.php' </script>";
  }

if(isset($_POST['DetaBtn'])){
    echo "<script>alert('Please Log in to your account.');</script>";
    echo"<script>window.location.href='log-in.php' </script>";
  }

if(isset($_POST['UnCartBtn'])){
    echo "<script>alert('Please Log in to your account.');</script>";
    echo"<script>window.location.href='log-in.php' </script>";
  }

?>