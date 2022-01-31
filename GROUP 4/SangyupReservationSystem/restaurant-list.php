<!-- restaurant-list.php -->

<?php 
if (isset($_POST['find'])) {
  $area_id = $_POST['area'];

                        include 'dbCon.php';
  include 'template/header.php'; ?>
  <body>
    
   <?php include 'template/nav-bar.php'; ?>
    <!-- END nav -->
    
    <section class="home-slider owl-carousel" >
      <div class="slider-item" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center">
            <div class="col-md-10 col-sm-12 ftco-animate text-center" >
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Restaurants</span></p>
              <h1 class="mb-3">Restaurants List</h1>
            </div>
          </div>
        </div>
      </div>


    </section>


    

    <section class="ftco-section bg-light">
    <div class="container-fluid">
      <div class="row justify-content-center mb-5 pb-5">
        <div class="col-md-7 text-center heading-section ftco-animate">
          <span class="subheading">Our Restaurants</span>
          <h2>Discover Our Exclusive Restaurants</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-7">
              <div id="map" style="height: 100%"></div>
        </div>
        <div class="col-5">

            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12 dish-menu">

                  <div class="nav nav-pills justify-content-center ftco-animate" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link py-3 px-4 active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><span class="flaticon-meat"></span> Main</a>
                  </div>

                  <div class="tab-content py-5" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                      <div class="row">
                        <?php  
                          $con = connect();
                          $sql = "SELECT * FROM `restaurant_info` WHERE location = '$area_id' and role=1 and approve_status=1;";
                          $result = $con->query($sql);
                          foreach ($result as $r) {
                        ?>
                        <div class="col-lg-12">
                          <div class="menus d-flex ftco-animate">
                            <div class="menu-img" style="background-image: url(dashboard/user-image/<?php echo $r['logo']; ?>)"></div>
                            <div class="text d-flex">
                              <div class="row one-half">
                                <div class="col-lg-12">
                                  <h3><?php echo $r['restaurent_name']; ?></h3>
                                </div>
                                <div class="col-lg-12">
                                  <p><?php echo $r['address']; ?></p>
                                </div>
                                <div class="col-lg-12">
                                  <p>RATING:
                                    <?php  
                                        $rating = 0;
                                        $id = $r['id'];

                                        $totalrating = 0;
                                        $loop = 0;

                                        $sql2 = "SELECT * FROM `tbl_feedback` WHERE `res_id` = '$id'";
                                        $result2 = $con->query($sql2);

                                        if (mysqli_num_rows ( $result2 ) > 0) {
                                          foreach ($result2 as $r2) {

                                            $totalrating = (int)$totalrating + (int)$r2['poll'];
                                            $loop = (int)$loop + 1;

                                          }

                                          $rating = (float)$totalrating / (float)$loop;

                                         

                                          $wholenumberrate = explode(".", $rating);

                                          if ($wholenumberrate[0] == 1) {
                                            echo '<i class="fas fa-star"></i>';
                                            if ($wholenumberrate[0] > 0) {
                                              echo '<i class="fas fa-star-half"></i>';
                                            }
                                            else{
                                               echo '<i class="far fa-star"></i>';
                                            }
                                            echo '<i class="far fa-star"></i>';
                                            echo '<i class="far fa-star"></i>';
                                            echo '<i class="far fa-star"></i>';
                                          }
                                          else if ($wholenumberrate[0] == 2) {
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';
                                            if ($wholenumberrate[0] > 0) {
                                              echo '<i class="fas fa-star-half"></i>';
                                            }
                                            else{
                                               echo '<i class="far fa-star"></i>';
                                            }
                                            echo '<i class="far fa-star"></i>';
                                            echo '<i class="far fa-star"></i>';

                                          }
                                          else if ($wholenumberrate[0] == 3) {
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';
                                            if ($wholenumberrate[0] > 0) {
                                              echo '<i class="fas fa-star-half"></i>';
                                            }
                                            else{
                                               echo '<i class="far fa-star"></i>';
                                            }
                                            echo '<i class="far fa-star"></i>';
                                          }
                                          else if ($wholenumberrate[0] == 4) {
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';

                                            if ($wholenumberrate[0] > 0) {
                                              echo '<i class="fas fa-star-half"></i>';
                                            }
                                            else{
                                               echo '<i class="far fa-star"></i>';
                                            }
                                           
                                          }
                                          else if ($wholenumberrate[0] == 5) {
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';
                                            echo '<i class="fas fa-star"></i>';
                                          }
                                        }
                                        else{
                                          echo "No feedback yet";
                                        }
                                        

                                    ?>
                                  </p>
                                </div>
                                <div class="col-lg-12">   
                                  <p>Total Reviews:
                                    <?php  
                                        $rating = 0;
                                        $id = $r['id'];

                                        $totalrating = 0;
                                        $loop = 0;

                                        $sql2 = "SELECT * FROM `tbl_feedback` WHERE `res_id` = '$id'";
                                        $result2 = $con->query($sql2);

                                        $rowcount =mysqli_num_rows( $result2 );
                                        echo $rowcount;
                                        

                                    ?>
                                  </p>
                                </div>
                              </div>
                              <div class="one-third">
                                <a href="reservation.php?res_id=<?php echo $r['id']; ?>" class="btn btn-info" style="width: 100%;margin-left: 23px;margin-top: 18px;">Book Table</a>
                                <a href="delivery.php?res_id=<?php echo $r['id']; ?>" class="btn btn-info" style="width: 100%;margin-left: 23px;margin-top: 18px;">Pick-Up</a>
                             
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                    </div><!-- END -->
                  </div>
                </div>
              </div>
            </div>
    </section>

    <?php include 'template/footer.php'; ?>
    
    <?php include 'template/script.php'; ?>
    <script type="text/javascript">

    	let map, infoWindow;
      function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 11,
          center: { lat: 14.642664, lng: 120.477945 },
        });

        
        infoWindow = new google.maps.InfoWindow();
        loadmylocation();

		  // const locationButton = document.createElement("button");

		  // locationButton.textContent = "Show my location";
		  // locationButton.classList.add("custom-map-control-button");
		  // locationButton.classList.add("custom-map-control-button");
		  // locationButton.classList.add("custom-map-control-button");
		  // map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
		  // locationButton.addEventListener("click", () => 

		  	function loadmylocation(){
		    // Try HTML5 geolocation.
		    if (navigator.geolocation) {
		      navigator.geolocation.getCurrentPosition(
		        (position) => {
		          const pos = {
		            lat: position.coords.latitude,
		            lng: position.coords.longitude,
		          };

		          infoWindow.setPosition(pos);
		          infoWindow.setContent("Your Location.");
		          infoWindow.open(map);
		          map.setCenter(pos);
		        },
		        () => {
		          handleLocationError(true, infoWindow, map.getCenter());
		        }
		      );
		    } else {
		      // Browser doesn't support Geolocation
		      handleLocationError(false, infoWindow, map.getCenter());
		    }
		  }
		  setMarkers(map);
      }



      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		  infoWindow.setPosition(pos);
		  infoWindow.setContent(
		    browserHasGeolocation
		      ? "Error: The Geolocation service failed."
		      : "Error: Your browser doesn't support geolocation."
		  );
		  infoWindow.open(map);
		}







      const restaurantlocation = [

      <?php 
          $con = connect();
          $sql = "SELECT * FROM `restaurant_info` WHERE location = '$area_id' and role=1 and approve_status=1";
          $result = $con->query($sql);
          foreach ($result as $r) {
          echo "[".$r['latitude'].','.$r['longitude'].",'".$r['restaurent_name']."','dashboard/user-image/".$r['logo']."'],"; 


      } ?>

      ];

      function setMarkers(map) {


        for (let i = 0; i < restaurantlocation.length; i++) {


          const resto = restaurantlocation[i];

          const contentString =
            resto[2];
          const infowindow = new google.maps.InfoWindow({
            content: contentString,
          });

          var icon = {
              url: resto[3], // url
              scaledSize: new google.maps.Size(30, 30), // scaled size
              origin: new google.maps.Point(0,0), // origin
              anchor: new google.maps.Point(0, 0) // anchor
          };

          const markername = new google.maps.Marker({
            position: { lat: resto[0], lng: resto[1] },
            icon:icon,
            map,
          });
          markername.addListener("click", () => {
            infowindow.open({
              anchor: markername,
              map,

              shouldFocus: false,
            });
          });

          infowindow.open({
              anchor: markername,
              map,
              shouldFocus: false,
            });
        }
      }

      $(".custom-map-control-button").click();
    </script>

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw9lahq_sYashBHjt3ucPX5IfNZYDJwlc&callback=initMap"></script>
  </body>
</html>
<?php 
  }else{

  }
 ?>