<?php 
session_start();

if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}
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
      echo"<script>window.location.href='product-details.php' </script>";
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
      echo"<script>window.location.href='product-details.php' </script>";
    }


    if(isset($_POST['viewStore'])){
        echo"<script>window.location.href='seller-storeAct.php' </script>";
    }
    if(isset($_POST['cancelOrdBtn'])){
      $date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
      $_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
      echo"".$_POST['prod_Size'];
      echo"".$_POST['prod_Quant'];
      $xql = "UPDATE order_list SET cancel_date ='".$_SESSION['timestamp']."- User Cancelled', status = 'Cancel', upd_date = '".$_SESSION['timestamp']."' where  order_id = '".$_SESSION['order_id']."'";
      if ($connection2->query($xql) === TRUE) {
        if($_POST['prod_Size'] == 'Small'){$size = 'small';}
        else if($_POST['prod_Size'] == 'Medium'){$size = 'medium';}
        else if($_POST['prod_Size'] == 'Large'){$size = 'large';}
        else if($_POST['prod_Size'] == 'X-Large'){$size = 'x_large';}
        $xql2 = "SELECT $size FROM product_value where  product_id = '".$_SESSION['product_id']."'";
        $res = mysqli_query($connection2, $xql2);
        $sizeQuant = mysqli_fetch_array($res)[$size];
        $totalQuant = $sizeQuant + $_POST['prod_Quant'];
        $xql2 = "UPDATE product_value SET  $size ='$totalQuant' where product_id = '".$_SESSION['product_id']."'";
          if ($connection2->query($xql2) === TRUE) {
            echo "<script>alert('Order Canceled');</script>";
          echo"<script>window.location.href='userprofile.php' </script>";
      }else{
            echo "Error Cancelation: " . $connection2->error;
          }
      }
    }
    
    if(isset($_POST['recieveOrdBtn'])){
    $date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
    $_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
    $xql = "UPDATE order_list SET recieve_date ='".$_SESSION['timestamp']."', status = 'Recieved' , upd_date = '".$_SESSION['timestamp']."' where  order_id = '".$_SESSION['order_id']."'";
    if ($connection2->query($xql) === TRUE) {
        echo "<script>alert('Order Recieved');</script>";
        echo"<script>window.location.href='userprofile.php' </script>";
    }else{
          echo "Error Completion: " . $connection2->error;
        }
  }
?>