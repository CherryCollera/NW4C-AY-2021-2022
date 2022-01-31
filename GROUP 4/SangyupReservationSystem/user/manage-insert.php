<!-- manage-insert.php -->
<?php
session_start();
include_once 'dbCon.php';
$con = connect();
    
    //add table
   

    if (isset($_GET['delap'])) {
		$id =$_GET['delap'];
		$sql ="UPDATE `booking_details` SET status = 4 WHERE id = '$id';";
		if ($con->query($sql) === TRUE) {
		echo '<script>alert("Cancelled.")</script>'; 
		echo '<script>window.location ="bookings.php"</script>';
		//header("Location: view-chair-list.php?table_id=".$tbl_id."");
	    } else {
			echo "Error: " . $sql . "<br>" . $con->error;
		} 
	}

	if (isset($_GET['rebook'])) {
		$id =$_GET['rebook'];
		
		$sql ="UPDATE `booking_details` SET status = 0 WHERE id = '$id';";
		if ($con->query($sql) === TRUE) {
		echo '<script>alert("Rebook.")</script>'; 
		echo '<script>window.location ="bookings.php"</script>';
		//header("Location: view-chair-list.php?table_id=".$tbl_id."");
	    } else {
			echo "Error: " . $sql . "<br>" . $con->error;
		} 
	}

	if (isset($_POST['payment'])){
	
		$booking_id = $_POST['booking_id'];
		$g_name = $_POST['g_name'];
		$g_number =  $_POST['g_number'];
	        	if (isset($_FILES['image'])) {
				 // files handle
				    $targetDirectory = "../dashboard/user-image/";
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
				    	$iquery="INSERT INTO `payment`(`booking_id`,`g_name`,`g_number`, `file`) 
			        		VALUES ('$booking_id','$g_name','$g_number','$file_name');";
			        	if ($con->query($iquery) === TRUE) {
			        		echo '<script>alert("Receipt Send Successfully")</script>';
			        		echo '<script>window.location="bookings.php"</script>';
			        	}else {
			                echo "Error: " . $iquery . "<br>" . $con->error;
			            }
				    	
				    }else{
				    	echo '<script>alert("Required JPG,PNG,GIF in Logo Field.")</script>';
		        		echo '<script>window.location="user/bookings.php"</script>';
				    }
				}else{
					$file_name = "";

					$iquery="INSERT INTO `payment`(`booking_id`,`g_name`,`g_number`, `file`) 
			        		VALUES ('$booking_id','$g_name','$g_number','$file_name');";
		        	if ($con->query($iquery) === TRUE) {
		        		echo '<script>alert("Receipt Send Successfully")</script>';
		        		echo '<script>window.location="bookings.php"</script>';
		        	}else {
		                echo "Error: " . $iquery . "<br>" . $con->error;
		            }
				}
        
				$sql ="UPDATE booking_details SET rfeestatus = 1 WHERE booking_id = '$booking_id';";
				// include_once 'dbCon.php';
				// $con = connect();
				if ($con->query($sql) === TRUE) {
				echo '<script>window.location="booking-list.php"</script>';
				} else {
					echo "Error: " . $sql . "<br>" . $con->error;
				} 
				

    }
	
?>