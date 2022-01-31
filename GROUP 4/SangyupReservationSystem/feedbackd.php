<!-- select-menu.php -->
<?php 
if (isset($_POST['bookdeli'])) {
    $_SESSION['isLoggedIn'] = TRUE;
    include_once 'dbCon.php';
    $con = connect();

    $bdinsert = false;
    $u_id = $_POST['u_id'];
    $res_id = $_POST['res_id'];
    $reservation_name = $_POST['reservation_name'];
    $reservation_phone = $_POST['reservation_phone'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $rfeestatus = 1;
    $reservation_type = 1;
    $total_price = $_POST['total_price'];


    date_default_timezone_set("Asia/Dhaka");
     $make_time =date("h:i:sa");
     $make_date =date("Y-m-d");
    $booking_id= uniqid();

    $iquery="INSERT INTO `booking_details`(`booking_id`,`res_id`,`c_id`,`make_date`, `make_time`, `name`, `phone`, `booking_date`, `booking_time`,`type`, `bill`,rfeestatus) 
        VALUES ('$booking_id','$res_id','$u_id','$make_date','$make_time','$reservation_name','$reservation_phone','$reservation_date','$reservation_time','$reservation_type','$total_price','$rfeestatus');";
    if ($con->query($iquery) === TRUE) {
        $bdinsert = true;
    }else {
        echo "Error: " . $iquery . "<br>" . $con->error;
    }

    $cinsert = true;
    $iinsert = false;
    if ($cinsert == true) {
        for($i = 0; $i < count($_POST["item"]); $i++){
            $i_id = $_POST['item'][$i];
            $qty = $_POST['qty'][$i];
            $itmQuery = "INSERT INTO `booking_menus`(`booking_id`, `item_id`, `qty`) 
                    VALUES ('$booking_id','$i_id','$qty');";
            if ($con->query($itmQuery) === TRUE) {
                $iinsert = true;
            }else {
                echo "Error: " . $itmQuery . "<br>" . $con->error;
            }
        }
    }

   if ($bdinsert == true && $cinsert == true && $iinsert == true) {
        echo '<script>alert("Your booking is done. You will get an email soon.")</script>';
        echo '<script>window.location="user/deliveryy.php"</script>';
        
    }else {
        echo "Error: " . $iquery . "<br>" . $con->error;
        echo "Error: " . $ciQuery . "<br>" . $con->error;
        echo "Error: " . $iquery . "<br>" . $con->error;
    }
     

   
  include 'template/header.php'; ?>
  <body>
    
     
    
    
    <?php include 'template/instagram.php'; ?>

    <?php include 'template/footer.php'; ?>

    <?php include 'template/script.php'; ?>
	
    
  </body>
</html>
<?php } ?>
