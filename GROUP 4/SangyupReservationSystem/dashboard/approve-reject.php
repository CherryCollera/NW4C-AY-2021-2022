<!-- approve-reject.php -->
<?php 
	session_start();
   include_once 'dbCon.php';
   $con = connect();  
	//reject 
	if (isset($_GET['breject_id'])) {
		$id =$_GET['breject_id'];
		$sql ="UPDATE booking_details SET status = 0 WHERE id = '$id';";
		// include_once 'dbCon.php';
		// $con = connect();
		if ($con->query($sql) === TRUE) {
		echo '<script>alert("Rejected.")</script>';
		echo '<script>window.location="booking-list.php"</script>';
	    } else {
			echo "Error: " . $sql . "<br>" . $con->error;
		} 
	}

	// approve booking request
	if (isset($_GET['bapprove_id'])) {
		$id =$_GET['bapprove_id'];
		include_once 'dbCon.php';
		$con = connect();
		$bookingid = "";

		$sql = "SELECT * FROM `booking_details` WHERE `id` = '$id'";
		$result = $con->query($sql);
		foreach ($result as $r) {
			$bookingid  = $r['booking_id'];
			

		}

		$sql = "SELECT * FROM `booking_menus` WHERE booking_id = '$bookingid'";
		$result = $con->query($sql);
		foreach ($result as $r) {

			$itemid = $r['item_id'].' ';
			$quantity =  $r['qty'].' ';
			$oldstock = 0;

			$sql2 = "SELECT * FROM `menu_item` WHERE id = '$itemid'";
	        $result2 = $con->query($sql2);

	        foreach ($result2 as $r2) {
	            $oldstock =  $r2['stocks'];
	        }

	        $stockremain = (int)$oldstock - (int)$quantity;

	        $stmt3 = $con->prepare("UPDATE `menu_item` SET `stocks`='$stockremain' where id ='$itemid'");
	        $stmt3->execute();

		}


		$sql ="UPDATE booking_details SET status = 1 WHERE id = '$id';";
		
		$sql2 ="SELECT `id`, `c_id`, (SELECT `restaurent_name` FROM `restaurant_info` WHERE restaurant_info.id= booking_details.c_id) as username,(SELECT `email` FROM `restaurant_info` WHERE restaurant_info.id= booking_details.c_id) as email FROM booking_details WHERE id = '$id';";
		$result= $con->query($sql2);
		
		if ($con->query($sql) === TRUE) {
	            echo  '<script>alert("Booking Confirmed.")</script>';
	            echo '<script>window.location="booking-list.php"</script>';
		
	    } else {
			echo "Error: " . $sql . "<br>" . $con->error;
		} 
	}

	if (isset($_GET['bdone_id'])) {
		$id =$_GET['bdone_id'];
		include_once 'dbCon.php';
		$con = connect();
		$bookingid = "";

		$sql = "SELECT * FROM `booking_details` WHERE `id` = '$id'";
		$result = $con->query($sql);
		foreach ($result as $r) {
			$bookingid  = $r['booking_id'];
			

		}

		$sql = "SELECT * FROM `booking_menus` WHERE booking_id = '$bookingid'";
		$result = $con->query($sql);
		foreach ($result as $r) {

			$itemid = $r['item_id'].' ';
			$quantity =  $r['qty'].' ';
			$oldstock = 0;
			$purchasedproduct = 0;
			$total = 0;

			$sql2 = "SELECT * FROM `menu_item` WHERE id = '$itemid'";
	        $result2 = $con->query($sql2);

	        foreach ($result2 as $r2) {
	            $oldstock =  $r2['stocks'];
				$purchasedproduct = $r2['sold_product'];
				$total = $r2['total'];
	        }

	        $stockremain = (int)$oldstock - (int)$quantity;
			$totalsoldproduct = (int)$purchasedproduct + (int)$quantity;

			$total = (int)$stockremain + (int)$totalsoldproduct;

	        $stmt3 = $con->prepare("UPDATE `menu_item` SET `stocks`='$stockremain', `sold_product`='$totalsoldproduct', `total`='$total' where id ='$itemid'");
	        $stmt3->execute();

		}


		$sql ="UPDATE booking_details SET status = 2 WHERE id = '$id';";
		
		$sql2 ="SELECT `id`, `c_id`, (SELECT `restaurent_name` FROM `restaurant_info` WHERE restaurant_info.id= booking_details.c_id) as username,(SELECT `email` FROM `restaurant_info` WHERE restaurant_info.id= booking_details.c_id) as email FROM booking_details WHERE id = '$id';";
		$result= $con->query($sql2);
		
		if ($con->query($sql) === TRUE) {
	            echo  '<script>alert("Booking Done.")</script>';
	            echo '<script>window.location="booking-list.php"</script>';
		
	    } else {
			echo "Error: " . $sql . "<br>" . $con->error;
		} 
	}
 

?>
 
 

?>
 
 