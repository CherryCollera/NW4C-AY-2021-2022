<?php 
    
session_start();

if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}

if(isset($_POST['buyEnd'])){
  $connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp");

if($_POST['prod_LocSel'] == 'Exist'){
  $deliver_loc = $_POST['prod_LocExi'];
}
if($_POST['prod_LocSel'] == 'Custom'){
  $deliver_loc = $_POST['prod_LocCus'];
}

  $date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
  $_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');

$sql2 = "SELECT brand_id FROM product_desc where  product_id = '".$_SESSION['product_id']."'";
$result2 = mysqli_query($connection, $sql2);
if (mysqli_num_rows($result2)>0){
    while($row = mysqli_fetch_array($result2)){
        $sql = "SELECT seller_id FROM brand_names where  brand_id = '".$row['brand_id']."'";
        $result = mysqli_query($connection, $sql);
        $seller_id = mysqli_fetch_array($result)['seller_id'];
    }
}
if(isset($seller_id)){
    if($connection->query("INSERT INTO order_list(seller_id, product_id, user_id, status, upd_date,buy_date, accept_date, ship_date, packed_date, cancel_date, recieve_date, prod_size, prod_quantity, prod_price, deliver_loc) VALUES ('$seller_id', '$_SESSION[product_id]', '$_SESSION[user_id]', 'Order', '$_SESSION[timestamp]','$_SESSION[timestamp]', '', '', '', '', '','$_POST[prod_Size]', '$_POST[prod_Quant]', '$_POST[prod_Price]', '$deliver_loc')")){
    if($_POST['prod_Size'] == 'Small'){$size = 'small';}
    if($_POST['prod_Size'] == 'Medium'){$size = 'medium';}
    if($_POST['prod_Size'] == 'Large'){$size = 'large';}
    if($_POST['prod_Size'] == 'X-Large'){$size = 'x_large';}
        $xql = "SELECT $size FROM product_value where  product_id = '".$_SESSION['product_id']."'";
        $res = mysqli_query($connection, $xql);
        $sizeQuant = mysqli_fetch_array($res)[$size];
        $totalQuant = $sizeQuant - $_POST['prod_Quant'];
        $xql2 = "UPDATE product_value SET  $size ='$totalQuant' where product_id = '".$_SESSION['product_id']."'";
          if ($connection->query($xql2) === TRUE) {
            echo "<script>alert('Product Successfully Ordered, Wait for Seller Response');</script>";
          }else{
            echo "Error Purchase: " . $connection->error;
          }
    }else{
        echo"Error".$connection->error;
        }
    }
            echo"<script>window.location.href='userhome.php' </script>";

}

?>
