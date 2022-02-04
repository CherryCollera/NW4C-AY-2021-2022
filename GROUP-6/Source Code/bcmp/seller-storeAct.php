<?php
session_start();
if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}

if(isset($_POST['btn_store'])){
    if($_POST['btn_store'] == "report"){
        echo"<script>window.location.href='seller-report.php' </script>";
    }
    if($_POST['btn_store'] == "feedback"){
        echo"<script>window.location.href='seller-feedback.php' </script>";
    }
}else{
$_SESSION['showUsers'] = "Best";

if(isset($_POST['tranBtn'])){
    if($_POST['tranBtn'] == "Best"){
        $_SESSION['showUsers'] = "Best";
    }else if($_POST['tranBtn'] == "All"){
        $_SESSION['showUsers'] = "All";
    }else if($_POST['tranBtn'] == "Feed"){
        $_SESSION['showUsers'] = "Feed";
    }
}
    echo"<script>window.location.href='product-store.php' </script>";

}
?>