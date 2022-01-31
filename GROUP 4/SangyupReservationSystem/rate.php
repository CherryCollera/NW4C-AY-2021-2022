<!-- reservation.php -->
<?php include 'template/header.php';

include 'dbCon.php';
if (!isset($_SESSION['isLoggedIn'])) {
    echo '<script>alert("You need to login first.")</script>';
    echo '<script>window.location="login.php"</script>';
    }
    if (isset($_POST['reservation'])) {
      $_SESSION['isLoggedIn'] = TRUE;
    }
?>
  

  <body>
    
   <?php include 'template/nav-bar.php'; ?>
    <!-- END nav -->
    
    <section class="home-slider owl-carousel"  >
      <div class="slider-item" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center">
            <div class="col-md-10 col-sm-12 ftco-animate text-center"  >
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Reservation</span></p>
              <h1 class="mb-3">Make a Reservation</h1>
            </div>
          </div>
        </div>
      </div>
    </section>

   

    
    <section class="ftco-section bg-light">
          	<form action="manage-insert.php" method="POST">
	          	<div class="col-lg-12" style="text-align: center;">
                  <h2 class="h4 mb-4">Food</h2>

                  <div class="form-group">
					<label class="control-label">Rate our food</label>
						<select data-plugin-selectTwo class="form-control populate" name="poll" placeholder="-Select-" required="">
										
            <option value="5">★★★★★</option>
						<option value="4">★★★★</option>
						<option value="3">★★★</option>
						<option value="2">★★</option>
                        <option value="1">★</option>

					</select>
				</div>
                <div class="form-group">
							<textarea class="form-control" name="fb" id="textareaDefault" placeholder="Comment"></textarea>
						</div>


            <h2 class="h4 mb-4">Service</h2>
            <div class="form-group">
					<label class="control-label">Rate our Service</label>
						<select data-plugin-selectTwo class="form-control populate" name="pollser" placeholder="-Select-" required="">
										
            <option value="5">★★★★★</option>
						<option value="4">★★★★</option>
						<option value="3">★★★</option>
						<option value="2">★★</option>
                        <option value="1">★</option>

					</select>
				</div>
                <div class="form-group">
						
							<textarea class="form-control" name="fbser" id="textareaDefault"></textarea>
						</div>
            
                    
                    <input type="hidden" name="name" value="<?php echo $_SESSION['name'];?>">
                    <input type="hidden" name="res_id" value="<?php echo $_GET['res_id']; ?>">
                    <input type="submit" value="Submit" name="feedback" class="btn btn-primary py-3 px-5">
	 
					
	            </div>
        	</form>
      </div>
    </section>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <?php include 'template/footer.php'; ?>
    
    <?php include 'template/script.php'; ?>


  </body>
</html>

<!--  
<?php include 'template/nav-bar.php'; ?>
    
    
   

    END nav -->