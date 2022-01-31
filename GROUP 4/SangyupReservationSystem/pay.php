<!-- signin.php -->
<?php 

include 'dbCon.php';
$con = connect();
include 'template/header.php'; ?>
  <body>
    
    <?php include 'template/nav-bar.php'; ?>
    <!-- END nav -->
    
    <section class="home-slider owl-carousel" style="height: 400px;">
      <div class="slider-item" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center">
            <div class="col-md-10 col-sm-12 ftco-animate text-center" style="padding-bottom: 25%;">
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Register</span></p>
              <h1 class="mb-3">Register</h1>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section bg-light">
      <div class="container">
        

            <!--register as customer-->
            <div class="tab-content py-5" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="row">
                  <div class="col-lg-2"></div>
                  <div class="col-lg-8">
                    <div class="menus d-flex ftco-animate" style="background: white;">
                      <div class="row" style="width: 100%">
                  <div class="col-md-12">
                    
                      <!-- register as customer -->
                      <form action="manage-insert.php" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                        <div class="form-group">
                          <input type="text" name="gcash" class="form-control" required="" placeholder="Name">
                        </div>
                        <div class="form-group">
                        <label for="image">Provide ID </label>
                          <input type="file" name="image" class="form-control" placeholder="ID" required="" >
                        </div>
                        <div class="form-group">
                        <input type="submit" value="Register" name="payment" class="btn btn-primary py-3 px-5">
                        </div>
                      </form>
                      <p class="text-center">For Login <a href="login.php">Click Here</a> </p>
                  </div>
              </div>
                  </div>
                  </div>
                </div>
              </div><!-- END -->

            

              
            </div>
          </div>
        </div>
      </div>
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Pin Location</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="map"></div>
          </div>
        </div>
      </div>
    </div>
    </section>

    <?php include 'template/instagram.php'; ?>

    <?php include 'template/footer.php'; ?>
    
    <?php include 'template/script.php'; ?>
   
  </body>
</html>