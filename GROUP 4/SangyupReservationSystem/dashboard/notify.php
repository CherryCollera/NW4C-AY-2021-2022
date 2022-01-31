<?php
  //##########################################################################
// ITEXMO SEND SMS API - PHP - CURL-LESS METHOD
// Visit www.itexmo.com/developers.php for more info about this API
//##########################################################################
function itexmo($number,$message,$apicode,$passwd){
		$url = 'https://www.itexmo.com/php_api/api.php';
		$itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
		$param = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($itexmo),
			),
		);
		$context  = stream_context_create($param);
		return file_get_contents($url, false, $context);
}
//##########################################################################
    //##########################################################################


    if ($_POST){
      $number = $_POST['number'];
      $name = $_POST['name'];
      $msg = $_POST['msg'];
      $api = "TR-KIRKS274483_268HE";
      $pass = "spddrre81g";
      $text = $name.": ".$msg;

      echo $text;
      
      
      if (!empty($_POST['name']) && ($_POST['number']) && ($_POST['msg'])){
  $result = itexmo($number,$text,$api,$pass);
  if ($result == ""){
  echo "iTexMo: No response from server!!!
  Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and viceversa.  Please CONTACT US for help. ";  
  }else if ($result == 0){
  echo "Message Sent!";
  echo '<script>window.location="booking-list.php"</script>';
  }
  else{ 
  echo "Error Num ". $result . " was encountered!";
  }
}

}


                  include 'dbCon.php';
									$con = connect();

                  $booking_number = $_GET['booking-number'];
									$sql2 = "SELECT * FROM `booking_details` where booking_id = '$booking_number';";
									$result2 = $con->query($sql2);
									foreach ($result2 as $r2) {
                    $booking_res = $r2['res_id'];
										$booking_date = $r2['booking_date'];
										$booking_time = $r2['booking_time'];
										$booking_name = $r2['name'];
										$booking_phone = $r2['phone'];
										$booking_type = $r2['type'];
			
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet"  href="css/bootstrap.min.css">

    <title>Notify</title>
  </head>
  <body>
    
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-6 col-xs-12"> 
        <form method="POST" action="notify.php">
        <div class="form-group ">  
<?php
        $sql = "SELECT * FROM `restaurant_info` where id = '$booking_res';";
									$result = $con->query($sql);
									foreach ($result as $r) {
                    $booking_resname = $r['restaurent_name'];
                    ?>
									      
          <label form="name" >Name</label>
          <input type="text" maxlength="" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo $booking_resname;?>" required="">
        </div>
        <?php }?>
        <div class="form-group ">
          <label form="number" >Number</label>
          <input type="text" maxlength="11" class="form-control" id="number" placeholder="Number" name="number" value="<?php echo $booking_phone;?>" required="">
        </div>
        <div class="form-group">
          <label for="msg" >Message:</label>
          <input type="text" maxlength="" class="form-control" id="msg" name="msg" value="<?php echo "Good Day ".$booking_name.", Booking Number:".$booking_number. "\r\n Status: Confirmed.";?>" required="">
        </div>
         <button type="submit" class="btn btn-success">Send</button>
      <?php }?>
      </div>
      </div>
    </div>
    </form>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS 
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>-->
    <script src="js/bootstrap.min.cs"></script>
    

    </script>
  </body>
</html>