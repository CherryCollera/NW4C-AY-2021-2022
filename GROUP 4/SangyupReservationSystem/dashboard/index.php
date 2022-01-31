<!-- booking-list.php -->
<?php include 'template/header.php'; 
if (!isset($_SESSION['isLoggedIn'])) {
	echo '<script>window.location="../login.php"</script>';
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
						<h2>Table</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Tables</span></li>
								<li><span>Booking List</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
						
						
					<script src="html5-qrcode.min.js"></script>
							<style>
							.result{
								background-color: green;
								color:#fff;
								padding:20px;
							}
							.row{
								display:flex;
							}
							</style>
							<div class="row">
							<div class="col">
								<div style="width:500px;" id="reader"></div>
							</div>
							<div class="col" style="padding:30px;">
								<div id="result">Result Here</div>
								<input type="text" name="text" id="text" readonly="" class="form-control">
								
							</div>
							</div>
							</div>
							<script type="text/javascript">
							function onScanSuccess(qrCodeMessage) {
								let qr = document.getElementById('text').value=qrCodeMessage;
								
							}
							function onScanError(errorMessage) {
							//handle scan error
							}
							var html5QrcodeScanner = new Html5QrcodeScanner(
								"reader", { fps: 100, qrbox: 250 });
							html5QrcodeScanner.render(onScanSuccess, onScanError);
							</script>
						
						
					<!-- end: page -->
				</section>
			</div>

			<?php include 'template/right-bar.php'; ?>
		

		<?php include 'template/script-res.php'; ?>
	</body>
</html>