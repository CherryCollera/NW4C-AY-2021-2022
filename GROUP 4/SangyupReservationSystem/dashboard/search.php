<!-- booking-list.php -->

	<body>
		<section class="body">

			

			

					

					<!-- start: page -->
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" name="datatable-tabletools" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
									<thead>
										<tr>
											<th>Menu</th>
											<th>Price</th>
											<th>Restaurant</th>
											<th>Book</th>
											
									</thead>
									<tbody>
										<?php
										$count = 1;
										include 'dbCon.php';
										$con = connect();
										
										$sql = "SELECT * FROM `menu_item` WHERE food_type = 'Fast Food' or food_type='Raw Meat'";
										$result = $con->query($sql);
										foreach ($result as $r) {
											
										?>

										<tr class="gradeX">
										<td><?php echo $r['item_name']; ?></td>
											<td><?php echo $r['price']; ?></td>
											<td><?php echo $r['res_id']; ?></td>
											
											<td class="center hidden-phone">
												<a href="invoice.php?booking-number=<?php echo $r['booking_id']; ?>" class="btn btn-primary">Book</a>
												
											</td>
										</tr>
										<?php $count++; } ?>
										
									</tbody>
								</table>
							</div>
						</section>
						
						
		
				
			</div>

		

		</section>
		<script type="text/javascript">
	       function Done(){
	         return confirm("Are you sure?");
	       }
   		</script>

		<?php include 'template/script-res.php'; ?>
	</body>
</html>