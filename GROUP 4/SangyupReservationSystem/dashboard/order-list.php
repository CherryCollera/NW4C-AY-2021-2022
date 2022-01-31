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
						<h2>Pick-Up List</h2>
					
						<div class="right-wrapper pull-right">
							
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
						
						
						<section class="panel">
                            
							<div class="panel-body">
							<div class="panel-body">
									<div class="row">
									<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">DATE</label>
										<input type="date" name="" id="getdate"><br>
									</div>
									</div>
							</div>
							<div id ="tblDiv">
								<table class="table table-bordered table-striped mb-none" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
									<thead>
										<tr>
											<th>No</th>
											<th>Booking Id</th>
											<th>Name</th>
											<th>Phone</th>
											<th>Date</th>
											<th>Time</th>
											<th>Bill</th>
											<th class="hidden-phone">Status</th>
											<th class="hidden-phone">Action</th>
											<th class="hidden-phone">View</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										include 'dbCon.php';
										$con = connect();
										$res_id = $_SESSION['id'];
										$sql = "SELECT * FROM `booking_details` WHERE res_id = '$res_id' and type = 1 ORDER BY make_date DESC;";
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
											<td> ₱ <?php echo $r['bill']; ?></td>
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
												<a href="approve-reject.php?bapprove_id=<?php echo $r['id']; ?>&booking-number=<?php echo $r['booking_id']; ?>" class="btn btn-success"  onclick="if (!Done()) return false; ">Confirm</a>	
												
												<?php }else if($status == 1){ ?>
													<a href="approve-reject.php?bdone_id=<?php echo $r['id']; ?>&booking-number=<?php echo $r['booking_id']; ?>" class="btn btn-success"  onclick="if (!Done()) return false; ">Done</a>	
												<?php } ?>
											</td>
											<td class="center hidden-phone">
												<a href="invoice.php?booking-number=<?php echo $r['booking_id']; ?>" class="btn btn-primary">View</a>
												<a href="notify.php?booking-number=<?php echo $r['booking_id']; ?>" class="btn btn-primary">Notify</a>
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
		<script>
		$(document).on("change","#getdate", function(){
				var date = $('#getdate').val();
				$.ajax({
					url: "order-ajax.php",
					method: "POST",
					dataType: "text",
					data: {
						date : date
					},
					success: function(response){
					
						$('#tblDiv').html(response);
					}
				});
			});</script>
		<script type="text/javascript">
	       function Done(){
	         return confirm("Are you sure?");
	       }
   		</script>

		<?php include 'template/script-res.php'; ?>
	</body>
</html>