<?php

session_start();

if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}

    
echo"".$_POST['rateValue'];
echo"".$_POST['rateDesc'];
echo "".$_SESSION['prodImg'];

if(isset($_POST['addRateBtn'])){
$date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
$_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
  $connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp");
$sql = "SELECT * FROM product_rate where product_id = '".$_SESSION['product_id']."' && order_id = '".$_SESSION['order_id']."' && rater_id = '".$_SESSION['user_id']."'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result)>0){
    echo "<script>alert('You Can Only Rate Once.')</script>";
}else{


    // $sql = "INSERT into product_rate (product_id, order_id, rater_id, rate_value, rate_desc, rate_time) value ('$_SESSION[product_id]','$_SESSION[order_id]', '$_SESSION[user_id]', '$_POST[rateValue]', '$_POST[rateDesc]', '$_SESSION[timestamp]')";
    // if($connection->query($sql)) {
    // echo "<script>alert('Product Rated: Thanks for your feedback');</script>";
    // }else {
    // echo "<script>alert('Error Rate: $connection->error');</script>";
    // }
  }
//   echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
// echo"<script>window.location.href='userprofile.php' </script>";

}

?>