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
      <div class="container">
        <div class="row no-gutters justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2>Choose a Reservation Date and Time</h2>
          </div>
        </div>
        <div class="row d-flex">
          <div class="col-md-4 ftco-animate img" style="background-image: url(images/bg_1.jpg);"></div>
          <div class="col-md-8 ftco-animate makereservation p-5 bg-light">
            
            <form action="choose-table.php" method="POST">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="reservation_name" class="form-control" placeholder="Your Name" required="" value="<?php echo $_SESSION['name'];?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" name="reservation_phone" class="form-control" placeholder="Phone" required="" value="<?php echo $_SESSION['phone'];?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Date</label>
                    <input type="date" name="reservation_date" class="form-control" placeholder="Date" required="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Time</label>
                    <select name="reservation_time" class="form-control" placeholder="Time" required="">
                      <option value="10:00am">10:00am</option>
                      <option value="10:45am">10:45am</option>
                      <option value="11:30am">11:30am</option>
                      <option value="12:15pm">12:15pm</option>
                      <option value="1:15pm">1:15pm</option>
                      <option value="2:15pm">2:15pm</option>
                      <option value="3:15pm">3:15pm</option>
                      <option value="4:15pm">4:15pm</option>
                      <option value="5:15pm">5:15pm</option>
                      <option value="6:15pm">6:15pm</option>
                      <option value="7:15pm">7:15pm</option>
                      <option value="8:00pm">8:00pm</option>
                      <option value="8:45pm">8:45pm</option>
                      <option value="9:30pm">9:30pm</option>
                    </select>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3">
                  <div class="form-group">
                    <input type="hidden" name="res_id" value="<?php echo $_GET['res_id']; ?>">
                    <input type="submit" name="reservation" value="Submit" class="btn btn-primary py-3 px-5">
                  </div>
                </div>
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