<!-- manage-insert.php -->
<?php 
session_start();
include_once 'dbCon.php';
$con = connect();
	if (isset($_POST['regascus'])){
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
		$location = $_POST['town'];
        $password = $_POST['password'];
		$approve_status = 0;
        $role = 2;

        echo $lat;
        echo ' '.$long;

        

        // existing email chaeck
        $checkSQL = "SELECT * FROM `restaurant_info` WHERE phone = '$phone' or email ='$email';";
        $checkresult = $con->query($checkSQL);
        if ($checkresult->num_rows > 0) {
        	echo '<script>alert("E-Mail or Phone Number is already registered.")</script>';
        	echo '<script>window.location="register.php"</script>';
        }else{

	        	if (isset($_FILES['image'])) {
				 // files handle
				    $targetDirectory = "dashboard/user-image/";
				    // get the file name
				    $file_name = $_FILES['image']['name'];
				    // get the mime type
				    $file_mime_type = $_FILES['image']['type'];
				    // get the file size
				    $file_size = $_FILES['image']['size'];
				    // get the file in temporary
				    $file_tmp = $_FILES['image']['tmp_name'];
				    // get the file extension, pathinfo($variable_name,FLAG)
				    $extension = pathinfo($file_name,PATHINFO_EXTENSION);

				    //register as customer
				    if ($extension =="jpg" || $extension =="png" || $extension =="jpeg"){
				    	move_uploaded_file($file_tmp,$targetDirectory.$file_name);
				    	$iquery="INSERT INTO `restaurant_info`(`restaurent_name`, `email`, `phone`, `address`,`location`, `logo`, `password`,`approve_status`, `role`) 
			        		VALUES ('$fullname','$email','$phone','$address','$location','$file_name','$password','$approve_status','$role');";
			        	if ($con->query($iquery) === TRUE) {
			        		echo '<script>alert("You Register successfully")</script>';
			        		echo '<script>window.location="login.php"</script>';
			        	}else {
			                echo "Error: " . $iquery . "<br>" . $con->error;
			            }
				    	
				    }else{
				    	echo '<script>alert("Required JPG,PNG,GIF in Logo Field.")</script>';
		        		echo '<script>window.location="register.php"</script>';
				    }
				}else{
					$file_name = "";

					$iquery="INSERT INTO `restaurant_info`(`restaurent_name`, `email`, `phone`, `address`, `logo`, `password`, `role`) 
			        		VALUES ('$fullname','$email','$phone','$address','$file_name','$password','$role');";
		        	if ($con->query($iquery) === TRUE) {
		        		echo '<script>alert("New faculty added successfully")</script>';
		        		echo '<script>window.location="register.php"</script>';
		        	}else {
		                echo "Error: " . $iquery . "<br>" . $con->error;
		            }
				}
        }
    }

	//register as restaurant
	if (isset($_POST['regasres'])){
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        // $bkashnumber = $_POST['bkashnumber'];
        $address = $_POST['address'];
        $area = $_POST['area'];
        $password = $_POST['password'];
        $lat = $_GET['lat'];
        $long = $_GET['long'];
		$approve_status = 0;
        $role = 1;

        

        $checkSQL = "SELECT * FROM `restaurant_info`  WHERE phone = '$phone' or email ='$email';";
        $checkresult = $con->query($checkSQL);
        if ($checkresult->num_rows > 0) {
        	echo '<script>alert("Restaurant With This E-Mail or Phone Number Is Already Exit.")</script>';
        	echo '<script>window.location="register.php"</script>';
        }else{

	        	if (isset($_FILES['image'])) {
				 // files handle
				    $targetDirectory = "dashboard/user-image/";
				    // get the file name
				    $file_name = $_FILES['image']['name'];
				    // get the mime type
				    $file_mime_type = $_FILES['image']['type'];
				    // get the file size
				    $file_size = $_FILES['image']['size'];
				    // get the file in temporary
				    $file_tmp = $_FILES['image']['tmp_name'];
				    // get the file extension, pathinfo($variable_name,FLAG)
				    $extension = pathinfo($file_name,PATHINFO_EXTENSION);

				    if ($extension =="jpg" || $extension =="png" || $extension =="jpeg"){
				    	move_uploaded_file($file_tmp,$targetDirectory.$file_name);
				    	$iquery="INSERT INTO `restaurant_info`(`restaurent_name`, `email`, `phone`, `address`, `location`, `logo`, `password`,`approve_status`, `role` ,`latitude`,`longitude`) 
			        		VALUES ('$fullname','$email','$phone', '$address','$area','$file_name','$password','$approve_status','$role','$lat','$long');";
			        	if ($con->query($iquery) === TRUE) {


			        			echo '<script>alert("Restaurant added successfully")</script>';
			        				echo '<script>window.location="login.php"</script>';

			        		// $id = $con->insert_id;



			    //     		include 'dashboard/mailSender.php'; 
							// $mail->Body = '<html><body>
					  //                Verify your account.. click the link below.
					  //                http://localhost/tablereservation/verifyaccount.php?email='.$email.'&id='.$id.'&auth='.$password.'
					  //               </body></html>'; 
					  //           $mail->addAddress($email, "Booking Approve");
					  //           if($mail->send()) {
					  //           	 echo '<script>alert("Restaurant added successfully")</script>';
			    //     				echo '<script>window.location="verifyaccount.php?view=verifyaccount&email='.$email.'&id='.$id.'&auth='.$password.'"</script>';
					  //         //   	echo '<script>alert("Restaurant added successfully")</script>';
			    //     				// echo '<script>window.location="login.php"</script>';
					  //           }else{
					  //             	echo '<script>alert("Restaurant added successfully")</script>';
			    //     				echo '<script>window.location="login.php"</script>';
					  //           } 




			        	
			        	}else {
			                echo "Error: " . $iquery . "<br>" . $con->error;
			            }
				    	
				    }else{
				    	echo '<script>alert("Required JPG,PNG,GIF in Logo Field.")</script>';
		        		echo '<script>window.location="register.php"</script>';
				    }
				}else{
					$file_name = "";

					$iquery="INSERT INTO `restaurant_info`( `restaurent_name`, `email`, `phone`, `address`, `location`, `logo`, `password`, `role`,`latitude`,`longitude`) 
		        		VALUES ('$fullname','$email','$phone', '$address','$area', '$file_name','$password','$role','$lat','$long','15','15');";
		        	if ($con->query($iquery) === TRUE) {
		        		echo '<script>alert("New faculty added successfully")</script>';
		        		echo '<script>window.location="login.php"</script>';
		        	}else {
		                echo "Error: " . $iquery . "<br>" . $con->error;
		            }
				}
        }
    }


	if (isset($_POST['bookdeli'])) {

		$_SESSION['isLoggedIn'] = TRUE;


    	$bdinsert = false;
    	$u_id = $_SESSION['id'];
    	$res_id = $_POST['res_id'];
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
    		echo '<script>window.location="appointment.php"</script>';
			
    	}else {
    		echo "Error: " . $iquery . "<br>" . $con->error;
    		echo "Error: " . $ciQuery . "<br>" . $con->error;
            echo "Error: " . $iquery . "<br>" . $con->error;
        } 
    }	
	if (isset($_GET['delap'])) {
		$id =$_GET['delap'];
		$sql ="DELETE FROM `booking_details` WHERE id = '$id';";
		if ($con->query($sql) === TRUE) {
		echo '<script>alert("Cancelled.")</script>'; 
		echo '<script>window.location ="appointment.php"</script>';
		//header("Location: view-chair-list.php?table_id=".$tbl_id."");
	    } else {
			echo "Error: " . $sql . "<br>" . $con->error;
		} 
	}

	if (isset($_POST['feedback'])) {
		$res_id = $_POST['res_id'];
		$poll = $_POST['poll'];
		$feedback = $_POST['fb'];
		$pollser = $_POST['pollser'];
		$feedbackser = $_POST['fbser'];
		$name = $_POST['name'];

		$iquery="INSERT INTO `tbl_feedback`( `res_id`,`name`,  `feedback`, `poll`,`feedbackser`, `pollser`) 
		        		VALUES ('$res_id','$name','$feedback','$poll','$feedbackser','$pollser');";
		        	if ($con->query($iquery) === TRUE) {
		        		echo '<script>alert("Thankyou")</script>';
		        		echo '<script>window.location="index.php"</script>';
		        	}else {
		                echo "Error: " . $iquery . "<br>" . $con->error;
		            }
	}

	if (isset($_POST['payment'])){
       
        $gcash = $_POST['gcash'];
	        	if (isset($_FILES['image'])) {
				 // files handle
				    $targetDirectory = "dashboard/user-image/";
				    // get the file name
				    $file_name = $_FILES['image']['name'];
				    // get the mime type
				    $file_mime_type = $_FILES['image']['type'];
				    // get the file size
				    $file_size = $_FILES['image']['size'];
				    // get the file in temporary
				    $file_tmp = $_FILES['image']['tmp_name'];
				    // get the file extension, pathinfo($variable_name,FLAG)
				    $extension = pathinfo($file_name,PATHINFO_EXTENSION);

				    //register as customer
				    if ($extension =="jpg" || $extension =="png" || $extension =="jpeg"){
				    	move_uploaded_file($file_tmp,$targetDirectory.$file_name);
				    	$iquery="INSERT INTO `payment`(`gcash`, `file`) 
			        		VALUES ('$gcash','$file_name');";
			        	if ($con->query($iquery) === TRUE) {
			        		echo '<script>alert("You Register successfully")</script>';
			        		echo '<script>window.location="login.php"</script>';
			        	}else {
			                echo "Error: " . $iquery . "<br>" . $con->error;
			            }
				    	
				    }else{
				    	echo '<script>alert("Required JPG,PNG,GIF in Logo Field.")</script>';
		        		echo '<script>window.location="register.php"</script>';
				    }
				}else{
					$file_name = "";

					$iquery="INSERT INTO `payment`(`gcash`, `file`) 
					VALUES ('$gcash','$file_name');";
		        	if ($con->query($iquery) === TRUE) {
		        		echo '<script>alert("New faculty added successfully")</script>';
		        		echo '<script>window.location="register.php"</script>';
		        	}else {
		                echo "Error: " . $iquery . "<br>" . $con->error;
		            }
				}
        
    }
	

	
	
?>