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
						<h2>Users</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Users</span></li>
								<li><span>Customers</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
						
						
						<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-times"></a>
								</div>
						
								<h2 class="panel-title">All Users </h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
									<thead>
										<tr>
											<th>Name</th>
											<th>E-mail</th>
											<th>Address</th>
											<th>Phone</th>
											<th class="hidden-phone">Status</th>
											<th class="hidden-phone">View</th>
											
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										include 'dbCon.php';
										$con = connect();
										$res_id = $_SESSION['id'];
										$sql = "SELECT * FROM `restaurant_info` WHERE role = 2;";
										$result = $con->query($sql);
										foreach ($result as $r) {
										?>
										<tr class="gradeX">
											
											<td><?php echo $r['restaurent_name']; ?></td>
											<td><?php echo $r['email']; ?></td>
											<td><?php echo $r['address']; ?></td>
											<td><?php echo $r['phone']; ?></td>
											<td class="center hidden-phone">
												<?php 
													$status = $r['approve_status'];
													if ($status == 0) {
												?>
												<p class="text-danger">Pending</p>
												<?php }else{ ?>
													<p class="text-success">Approved</p>
												<?php } ?>
											</td>
											<td class="center hidden-phone">
											<?php 
													$status = $r['approve_status'];
													if ($status == 1) {
												?>
											
											<a href="approve-customer.php?getid=<?php echo $r['id']; ?>" class="btn btn-success"  onclick="if (!Done()) return false; ">View</a>
										
											<?php } else { ?>
											<a href="approve-customer.php?getid=<?php echo $r['id']; ?>" class="btn btn-success"  onclick="if (!Done()) return false; ">View</a>
											<a href="approve-reject.php?getid=<?php echo $r['id']; ?>" class="btn btn-primary"  onclick="if (!Done()) return false; ">Approve</a>
											<?php }?>
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