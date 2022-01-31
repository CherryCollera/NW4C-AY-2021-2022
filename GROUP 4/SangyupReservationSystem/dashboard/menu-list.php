<!-- menu-list.php -->
<?php include 'template/header.php'; 
if (!isset($_SESSION['isLoggedIn'])) {
	echo '<script>window.location="login.php"</script>';
}

?>
	<body>
	<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form name ="editform" id ="editform" action="menu-edit-ajax.php" method="post" enctype="multipart/form-data">
	  <input type="text" id="id" name ="id"   hidden>
	  		<label class="control-label">Name</label>
			<input type="text" id="itemname" name ="itemname" class="form-control">

			<label class="control-label">Price</label>
			<input type="number" id="price" name="price" class="form-control">

			<label class="control-label" style="display:none">Stocks</label>
			<input type="number" id="stocks" style="display:none" name ="stocks" class="form-control" disabled="">

			<label class="control-label">Description</label>
			
			<textarea class="form-control" name="madeby" id="madeby" ></textarea>
												

			<label class="control-label">Area</label>
			<select data-plugin-selectTwo class="form-control populate" id ="foodtype" name="foodtype" required="">
				<option value=""> -Select- </option>
				<option value="Fast Food">Fast Food</option>
				<option value="Add On">Add on</option>
				<option value="Drink">Drink</option>
			</select>
			
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" id="save" name = "save"class="btn btn-primary" value ="Save" >
		</form>
      </div>
    </div>
  </div>
</div>

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
						<h2>Menu List</h2>
					
					</header>

					<!-- start: page -->
						
						
						<section class="panel">
						
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
									<thead>
										<tr>
											<th>No</th>
											<th>Image</th>
											<th>Name</th>
											<th>Type</th>
											<th>Price</th>
											
											<th class="hidden-phone">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$res_id = $_SESSION['id'];
										$count = 1;
										include 'dbCon.php';
										$con = connect();
										$sql = "SELECT * FROM `menu_item` WHERE res_id = '$res_id';";
										$result = $con->query($sql);
										foreach ($result as $r) {
										?>
										<tr class="gradeX">
											<td class="center hidden-phone"><?php echo $count; ?></td>
											<td class="center hidden-phone">
												<figure  class="image rounded">
													<img id ="img<?php echo $r['id'];?>" style="height: 50px;width: 50px;border-radius: 10px;    border: 1px solid darkgray;" src="item-image/<?php echo $r['image']; ?>" alt="Item Image" >
												</figure>
												
											</td>
											<td id ="itemtd<?php echo $r['id'];?>"><?php echo $r['item_name'];?></td>
											<input type="text"id ="item<?php echo $r['id'];?>" value ="<?php echo $r['item_name'];?>" hidden>
											<td id ="foodtypetd<?php echo $r['id'];?>"><?php echo $r['food_type']; ?></td>
											<input type="text"id ="foodtype<?php echo $r['id'];?>" value ="<?php echo $r['food_type']; ?>" hidden>
											<td id ="pricetd<?php echo $r['id'];?>"><?php echo $r['price']; ?></td>
											<input type="text"id ="price<?php echo $r['id'];?>" value ="<?php echo $r['price'];?>" hidden>
											<!--<td id ="madebytd<?php echo $r['id'];?>"><?php echo $r['madeby']; ?></td>
											<input type="text"id ="madeby<?php echo $r['id'];?>" value ="<?php echo $r['madeby'];?>" hidden>
											<td id ="stockstd<?php echo $r['id'];?>"><?php echo $r['stocks']; ?></td>
											<input type="text"id ="stocks<?php echo $r['id'];?>" value ="<?php echo $r['stocks'];?>" hidden>-->
											<td class="center hidden-phone">
												<!--<a href="menu-manage.php?menu_id=<?php echo $r['id']; ?>" class="btn btn-danger"  onclick="if (!Done()) return false; ">Delete</a>-->
												<a href="#" class="btn btn-primary" id="edit" name = "<?php echo $r['id']; ?>">Edit</a>
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
		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>
		<script>
	
			$(document).on("click","#edit", function(){
				var name = $(this).attr('name');

				var itemname = $("#item"+name).val();
				var price = $("#price"+name).val();
				var stocks = $("#stocks"+name).val();
				var madeby = $("#madeby"+name).val();
				
				$("#id").val(name);
				$("#itemname").val(itemname);
				$("#price").val(price);
				$("#stocks").val(stocks);
				$("#madeby").val(madeby);
				$('#editmodal').modal('show');
			});
		
			$("#editform").submit(function(e){
				e.preventDefault();
				var itemname = $("#itemname").val();
				var price = $("#price").val();
				var stocks = $("#stocks").val();
				var madeby = $("#madeby").val();
				var foodtype = $("#foodtype").val();
				var id = $("#id").val();
				
				$.ajax({
					url: "menu-edit-ajax.php",
					method: "POST",
					dataType: "text",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					success: function(response){
						if(response = "updated") {            
							$("#itemtd"+id).html(itemname);
							$("#pricetd"+id).html(price);
							$("#stockstd"+id).html(stocks);
							$("#madebytd"+id).html(madeby);
							$("#foodtypetd"+id).html(foodtype);
							$("#itemname"+id).val(itemname);
							$("#price"+id).val(price);                                                                    
							$("#stocks"+id).val(stocks);
							$("#madeby"+id).val(madeby);
							$("#foodtype"+id).val(foodtype);
						
							$('#editmodal').modal('hide');
						} else if(response = "fileErr"){
							alert("Required JPG,PNG,GIF in Logo Field");
						}

					}
				});
			});

		</script>



	</body>
</html>