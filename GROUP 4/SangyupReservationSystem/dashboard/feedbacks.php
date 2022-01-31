<!-- booking-list.php -->
<?php include 'template/header.php'; 
if (!isset($_SESSION['isLoggedIn'])) {
	echo '<script>window.location="login.php"</script>';
}

?>
	<body>
	<style type="text/css">
        .user {
            font-weight: bold;
            color: black;
        }

        .time {
            color: gray;
        }

        .userComment {
            color: #000;
        }

        .replies .comment {
            margin-top: 20px;

        }

        .replies {
            margin-left: 20px;
        }

        #registerModal input, #logInModal input {
            margin-top: 10px;
        }
    </style>
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
						<h2>Feedbacks</h2>
					
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
							
							<div class="row">
								
										<?php
										$count = 1;
										include 'dbCon.php';
										$con = connect();
										$res_id = $_SESSION['id'];
										$sql = "SELECT * FROM `tbl_feedback` WHERE res_id = '$res_id';";
										$result = $con->query($sql);
										foreach ($result as $r) {
										?>
										<div class="col-md-12">
                                    <div class="userComments">
                                        <div class="comment">
                                            <div class="user"><?php echo $r['name']; ?></div>
											<div class="feedbacks"><?php echo $r['feedback']; ?></div>
											<div class="userComment"><?php 
													$poll = $r['poll'];
													if ($poll == 5){
												?>
												<p class="text-success">★★★★★</p>
												<?php }else if ($poll == 4){ ?>
													<p class="text-success">★★★★★</p>
                                                <?php }else if ($poll == 3){ ?>
													<p class="text-info">★★★</p>
                                                <?php }else if ($poll == 2){ ?>
													<p class="text-danger">★★</p>
                                                <?php }else if ($poll == 1){ ?>
													<p class="text-primary">★</p>
												<?php } ?></div>
                                            
											
                                    </div>
									</div>
                                </div>
										
										<?php $count++; } ?>
									
								</table>
							</div>

							        <div class="row">
                                
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