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
						<h2>Sales Report</h2>
					
						<div class="right-wrapper pull-right">
							
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
						
						
						<section class="panel">
							
							<div class="panel-body">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">DATE</label>
													<input type="date" name="" id="getdate"><br>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
												<label class="control-label">Total ₱:</label>
												<label id="total"></label>
												</div>
											</div>
										</div>
							</div>
							<div id ="tblDiv">
								<table class="table table-bordered table-striped mb-none" name="datatable-tabletools" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
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
										</tr>
									</thead>
									<tbody>
										<?php
										$today = date('d/m/Y');
										$sqlDate = date("Y-m-d", strtotime($today) );
										$count = 1;
										include 'dbCon.php';
										$con = connect();
										$res_id = $_SESSION['id'];
										$sql = "SELECT * FROM `booking_details` WHERE res_id = '$res_id' and status = 2 ORDER BY make_date DESC;";
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
											
										<?php $count++; } ?>
									</tbody>
								</table>
								
								
							</div>
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
        <script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>

        <script>

        $(document).ready(function() {
            var sum = $('#datatable-tabletools').DataTable().column(6).data().sum();
            $('#total').html(sum);
		
			
            });
			$(document).on("change","#getdate", function(){
				var date = $('#getdate').val();
				$.ajax({
					url: "sales-ajax.php",
					method: "POST",
					dataType: "text",
					data: {
						date : date
					},
					success: function(response){
					
						$('#tblDiv').html(response);
						var sum = $('#datatable-tabletools').DataTable().column(6).data().sum();
            $('#total').html(sum);
					}
				});
			});
           
        </script>
 
	</body>
</html>