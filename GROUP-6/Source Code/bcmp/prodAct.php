<?php
session_start();

if(!isset($_SESSION['name'])){
    echo"<script>alert('Sign in requiered:');
    window.location.href='log-in.php';
    </script>";
}

if(isset($_POST['DetaBtn'])){
    $_SESSION['product_id'] = $_POST['DetaBtn'];
    echo"<script>window.location.href='product-details.php' </script>";
}

if(isset($_POST['DetaBuyBtn'])){
  $_SESSION['order_id'] = $_POST['orderID'];
  $_SESSION['product_id'] = $_POST['DetaBuyBtn'];
  echo"<script>window.location.href='product-transaction.php' </script>";
}
// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

if(isset($_POST['BuyBtn'])){
    $date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
    $_SESSION['product_id'] = $_POST['BuyBtn'];
    $_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
  $sql = "INSERT into product_cart (product_id, user_id, timestamp) value ('$_SESSION[product_id]','$_SESSION[user_id]', '$_SESSION[timestamp]')";
  $sql2 = "SELECT * FROM product_cart where  product_id = '".$_SESSION['product_id']."' && user_id = '".$_SESSION['user_id']."'";
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
  $result2 = mysqli_query($connection2, $sql2);
  if (mysqli_num_rows($result2)>0){
  echo "<script>alert('Failed to Add to Cart: Product do exist.');</script>";
  }else{
  if($connection2->query($sql)) {
  echo "<script>alert('Product added to Cart');</script>";
  }else {
  echo "<script>alert('Error Add to cart: $connection2->error');</script>";
  }
}
  echo"<script>window.location.href='userhome.php' </script>";
}
if(isset($_POST['UnCartBtn'])){
  $_SESSION['product_id'] = $_POST['UnCartBtn'];
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
  $sql = "DELETE FROM product_cart WHERE product_id = '".$_SESSION['product_id']."' && user_id = '".$_SESSION['user_id']."'";
  if ($connection2->query($sql) === TRUE) {
  echo "<script>alert('Product remove from Cart');</script>";
  } else {
  echo "<script>alert('Error Uncarting: $connection2->error');</script>";
  }
  echo"<script>window.location.href='userhome.php' </script>";
}
?>