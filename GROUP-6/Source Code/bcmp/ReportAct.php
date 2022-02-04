<?php
    
session_start();

if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}

$date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
$_POST['report_Time'] = $date->format('Y-m-d h:i:s A');

if(isset($_POST['report_Btn'])){
    // echo "<script>alert('Error Add to cart:');</script>";
// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
  $connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql = "INSERT INTO seller_report(reporter_id, seller_id, report_title, report_desc, report_time, report_file) VALUES ('".$_SESSION['user_id']."','".$_SESSION['seller_id']."','".$_POST['report_Type']."','".$_POST['report_Desc']."','".$_POST['report_Time']."','".$_POST['report_File']."')";
if($connection2->query($sql)) {
    echo "<script>alert('Seller Reported: Admins will validate your report and assess accordingly');</script>";
    }else {
    echo "<script>alert('Error Add to cart: $connection2->error');</script>";
    }

}

?>