<!-- invoice.php -->
<?php include 'template/header.php'; 
if (!isset($_SESSION['isLoggedIn'])) {
	echo '<script>window.location="login.php"</script>';
}

?>
	<body>
		<section class="body">

			<!-- start: header -->
			<?php include 'template/top-bar.php'; ?>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php include 'template/left-bar.php'; ?>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Pay Reservation</h2>
					
						<div class="right-wrapper pull-right">
							
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->

					<section class="panel">
						<div class="panel-body">
							<div class="invoice">
								<header class="clearfix">
									<div class="row">
										<div class="col-sm-4 mt-md">
											<h2 class="h2 mt-none mb-sm text-dark text-bold">INVOICE</h2>
											<h4 class="h4 m-none text-dark text-bold">
											#<?php echo $_GET['booking-number']; ?></h4>
										</div>
										<?php 
											include 'dbCon.php';
											$con = connect();
											$c_id = $_SESSION['id'];
											$getRes ="SELECT * FROM `booking_details` where c_id = '$c_id';";
											$result = $con->query($getRes);
                							$row =  mysqli_fetch_assoc($result);

											$res_id = $row['res_id'];
											$sql = "SELECT * FROM `restaurant_info` where id = '$res_id';";
											$result = $con->query($sql);
											foreach ($result as $r) {
										?>
										<div class="col-sm-8 text-right mt-md mb-md">
											<address class="ib mr-xlg">
												<b class="text-capitalize"> G-Cash Name: <?php echo $r['restaurent_name']; ?></b>
												<br/>
                                                <b class="text-capitalize"> G-Cash Number:<?php echo $r['phone']; ?></b>
												<br/>
												<?php echo $r['email']; ?>
											</address>
											<div class="ib">
												<img style="width: 174px;height: 69px;" src="../dashboard/user-image/<?php echo $r['logo']; ?>" alt="<?php echo $r['restaurent_name']; ?>" />
											</div>
										</div>
										<?php } ?>
									</div>
								</header>
								<?php 	  
                                 $booking_number = $_GET['booking-number'];
									$sql2 = "SELECT * FROM `booking_details` where booking_id = '$booking_number';";
									$result2 = $con->query($sql2);
									foreach ($result2 as $r2) {
										$booking_date = $r2['booking_date'];
										$booking_time = $r2['booking_time'];
										$booking_name = $r2['name'];
										$booking_phone = $r2['phone'];
										
										$booking_type = $r2['type'];
									
                                     ?>

                                    <form action="manage-insert.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking_number; ?>">
                                    <div class="form-group">
                                    <label for="image">Your G-Cash Name</label>
                                    <input type="text" name="g_name" class="form-control" required="" value="<?php echo $booking_name; ?>">
                                    </div>
                                    <div class="form-group">
                                    <label for="image">Your G-Cash Number</label>
                                    <input type="text" name="g_number" class="form-control" required="" value="<?php echo $booking_phone; ?>">
                                    </div>
                                    <div class="form-group">
                                    <label for="image">Upload G-Cash Receipt </label>
                                    <input type="file" name="image" class="form-control" placeholder="" required="" >
                                    </div>
                                    <div class="form-group">
                                    <input type="submit" value="Pay" name="payment" class="btn btn-primary py-3 px-5">
                                    </div>
                                </form>
								
							<?php }?>
							</div>

							<div class="text-right mr-lg">	
							</div>
						</div>
					</section>

					<!-- end: page -->
				</section>
			</div>

			<?php include 'template/right-bar.php'; ?>
		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

	</body>
</html>