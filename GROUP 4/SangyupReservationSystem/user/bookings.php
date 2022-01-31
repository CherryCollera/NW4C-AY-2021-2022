<!-- booking-list.php -->
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
						<h2>Appointments</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
						
						
						<section class="panel">
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
									<thead>
										<tr>
											<th>No</th>
											<th>Booking Id</th>
											<th>Name</th>
											<th>Phone</th>
											<th>Date</th>
											<th>Time</th>
										
											<th class="hidden-phone">Status</th>
											<th class="hidden-phone">Action</th>
											<th class="hidden-phone">Reservation Fee</th>
											<th class="hidden-phone">View</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										include 'dbCon.php';
										$con = connect();
										$c_id = $_SESSION['id'];
										$sql = "SELECT * FROM `booking_details` WHERE c_id = '$c_id' and type =0 ORDER BY make_date DESC;";
										$result = $con->query($sql);
										foreach ($result as $r) {
										?>
										<tr class="gradeX">
											<td class="center hidden-phone"><?php echo $count; ?></td>
											<td class="center hidden-phone"><?php echo $r['booking_id']; ?></td>
											<td><?php echo $r['name']; ?></td>
											<td><?php echo $r['phone']; ?></td>
											<td><?php echo $r['booking_date']; ?></td>
											<td><?php echo $r['booking_time']; ?></td>
										
											<td class="center hidden-phone">
											<?php 
													$status = $r['status'];
													if ($status == 0) {
												?>
												<p class="text-dark">Pending</p>
												<?php }else if($status == 1){ ?>
													<p class="text-info">Confirmed</p>
												<?php }elseif($status == 2){ ?>
												<p class="text-success">Done</p>
												<?php }elseif($status == 3){ ?>
												<p class="text-warning">Cancelled</p>
												<?php }else if($status == 4){ ?>
													<p class="text-danger">Rejected</p>
												<?php } ?>
											</td>
											<td class="center hidden-phone">
												<?php 
													if ($status == 0) {
												?>
												<a href="manage-insert.php?delap=<?php echo $r['id']; ?>" class="btn btn-danger"  onclick="if (!Done()) return false; ">Cancel</a>	
												
												<?php }else if($status == 2){ ?>
													<a href="../rate.php?res_id=<?php echo $r['res_id']; ?>" class="btn btn-info"  onclick="if (!Done()) return false; ">Rate</a>
                               

												<?php } ?>
														
												
											</td>
											<td class="center hidden-phone">
											<?php 
													$rfeestatus = $r['rfeestatus'];
													if ($rfeestatus == 0) {
												?>
												<a href="pay.php?booking-number=<?php echo $r['booking_id']; ?>" class="btn btn-success">Pay</a>
											<?php } else{?>
												
												<?php 
													if ($status == 0) {
												?>
												<p class="text-info">On Process</p>
												<?php 
													} else {
												?>
												<a href="../choose-table1.php?booking_number=<?php echo $r['booking_id']; ?>" class="btn btn-info"  onclick="if (!Done()) return false; ">View Table</a>
												<?php } ?>
												<?php } ?>
											</td>
											<td class="center hidden-phone">
												<a href="invoice.php?booking-number=<?php echo $r['booking_id']; ?>" class="btn btn-primary">View</a>
												
											</td>
											
										</tr>
										<?php $count++; } ?>
									</tbody>
								</table>
							</div>
						</section>
						
						
					<!-- end: page -->
				</section>
			</div>

			<?php include 'template/right-bar.php'; ?>

		</section>
		<script type="text/javascript">
	       function Done(){
	         return confirm("Are you sure?");
	       }
   		</script>

		<?php include 'template/script-res.php'; ?>
	</body>
</html>