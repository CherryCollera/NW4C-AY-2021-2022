<!-- select-menu.php -->
<?php 
if (isset($_POST['book'])) {
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
    $reservation_address = '';
    $reservation_type = 0;
    $total_price = $_POST['total_price'];
    $transactionid ='';

    date_default_timezone_set("Asia/Dhaka");
     $make_time =date("h:i:sa");
     $make_date =date("Y-m-d");
    $booking_id= uniqid();

    $iquery="INSERT INTO `booking_details`(`booking_id`,`res_id`,`c_id`,`make_date`, `make_time`, `name`, `phone`, `booking_date`, `booking_time`,`type`, `bill`) 
        VALUES ('$booking_id','$res_id','$u_id','$make_date','$make_time','$reservation_name','$reservation_phone','$reservation_date','$reservation_time','$reservation_type','$total_price');";
    if ($con->query($iquery) === TRUE) {
        $bdinsert = true;
    }else {
        echo "Error: " . $iquery . "<br>" . $con->error;
    }

    $cinsert = false;
    if ($bdinsert == true) {
        for($q = 0; $q < count($_POST["chair"]); $q++){
            $c_id = $_POST['chair'][$q]; 
            $chair_no = ""; 
            $sql5 = "SELECT * FROM `restaurant_chair` WHERE id = '$c_id';";
            $result5 = $con->query($sql5);
            foreach ($result5 as $r5) {
                $chair_no = $r5['chair_no'];
            }
            $ciQuery = "INSERT INTO `booking_chair`(`booking_id`, `chair_id`, `chair_no`) 
                    VALUES ('$booking_id','$c_id','$chair_no');";
            if ($con->query($ciQuery) === TRUE) {
                $cinsert = true;
            }else {
                echo "Error: " . $ciQuery . "<br>" . $con->error;
            }
        }
    }

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
        echo '<script>alert("Your booking is done. You will get a text message soon.")</script>';
        echo '<script>window.location="user/bookings.php"</script>';
        
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
