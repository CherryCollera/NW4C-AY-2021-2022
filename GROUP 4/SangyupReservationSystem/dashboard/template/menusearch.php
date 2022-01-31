<!-- booking-list.php -->
<?php include 'header.php'; 

?>
	<body>
		<section class="body">

			

				<section role="main" class="content-body">
					

					
						
						
					
							
								
							</header>
						
								<table class="table table-bordered table-striped mb-none" name="datatable-tabletools" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
									<thead>
										<tr>
											<th>Menu</th>
											<th>Price</th>
											<th>Restaurant</th>
										
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										include 'dbCon.php';
										$con = connect();
										
										$sql = "SELECT * FROM `menu_item`";
										$result = $con->query($sql);
										foreach ($result as $r) {
										?>
										<tr class="gradeX">
											
											<td><?php echo $r['item_name']; ?></td>
											<td><?php echo $r['price']; ?></td>
											<td><?php echo $r['res_id']; ?></td>
											
										</tr>
										<?php $count++; } ?>
									</tbody>
								</table>
							</div>
						
						
						
					
				</section>
			</div>

			

		</section>
		
		<?php include 'template/script-res.php'; ?>
	</body>
</html>