<?php
session_start();
include_once 'dbCon.php';
$con = connect();
if (isset($_POST['bookdeli'])) {

		$_SESSION['isLoggedIn'] = TRUE;


    	$bdinsert = false;
    	$u_id = $_SESSION['id'];
    	$res_id = $_POST['res_id'];
		$feedback = $_POST['feedback'];
  		$reservation_name = $_POST['reservation_name'];
		$reservation_phone = $_POST['reservation_phone'];
		$reservation_date = $_POST['reservation_date'];
		$reservation_time = $_POST['reservation_time'];
		$reservation_address = $_POST['reservation_address'];
		$reservation_type = 1;
		$total_price = $_POST['total_price'];
		$transactionid = $_POST['transaction_id'];

		date_default_timezone_set("Asia/Dhaka");
         $make_time =date("h:i:sa");
         $make_date =date("Y-m-d");
		$booking_id= uniqid();

		$iquery="INSERT INTO `booking_details`(`booking_id`,`res_id`,`c_id`,`make_date`, `make_time`, `name`, `phone`, `booking_date`, `booking_time`,`address`,`type`, `bill`,`transactionid`) 
		    VALUES ('$booking_id','$res_id','$u_id','$make_date','$make_time','$reservation_name','$reservation_phone','$reservation_date','$reservation_time','$reservation_address','$reservation_type','$total_price','$transactionid');";
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
		
		$fquery="INSERT INTO `feedbacks`(`res_id`,`feedback`) 
			VALUES ('$res_id','$feedback');";
			if ($con->query($fquery) === TRUE) {
			$bdinsert = true;
			}else {
		echo "Error: " . $iquery . "<br>" . $con->error;
			}

    		echo '<script>alert("Your booking is done. You will get an email soon.")</script>';
    		echo '<script>window.location="appointment.php"</script>';
			
    	}else {
    		echo "Error: " . $iquery . "<br>" . $con->error;
    		echo "Error: " . $ciQuery . "<br>" . $con->error;
            echo "Error: " . $iquery . "<br>" . $con->error;
        } 
?>