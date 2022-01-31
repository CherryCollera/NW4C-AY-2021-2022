<!-- index.php -->
<!DOCTYPE html>
<style>
        *{
            margin: 0;
            padding: 0;
        }
        #map{
            height: 500px;
            width: 100px;
        }
    </style>

<?php include 'template/header.php'; ?>
  <body>
    
    <?php include 'template/nav-bar.php'; ?>
    <!-- END nav -->
    
    <section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image: url('images/bg_1.jpg');">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center text-center">
            <div class="col-md-10 col-sm-12 ftco-animate">
              <h1 class="mb-3">Book a table for yourself at a time convenient for you</h1>
            </div>
          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url('images/samgyeop.jpg');">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center text-center">
            <div class="col-md-10 col-sm-12 ftco-animate">
              <h1 class="mb-3">Samgyeopsal with your Friends</h1> 
            </div>
          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url('images/samg.jpg');">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center text-center">
            <div class="col-md-10 col-sm-12 ftco-animate">
              <h1 class="mb-3">Book a table for yourself at a time convenient for you</h1> 
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END slider -->

    <div class="ftco-section-reservation">
      <div class="container">
        <div class="row">
          <div class="col-md-12 reservation pt-5 px-5">
              <p style="font-size: 20px; color: #000;font-weight: bold;margin-top: -30px">Make a Reservation</p>
            <div class="block-17" style="min-height: 100px;">
              
              <form action="restaurant-list.php" method="POST" class="d-block d-lg-flex">
                <div class="fields d-block d-lg-flex">
                  <p style="font-size: 20px;color: #000">Town</p>
                  <div class="select-wrap one-half">
                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                    <select name="city" id="" class="form-control" disabled="">
                      <option value="Bataan">Bataan</option>
                    </select>
                  </div>
                    <p style="font-size: 20px;color: #000">Location</p>
                  <div class="select-wrap one-half">
                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                    <select data-plugin-selectTwo class="form-control populate" name="area" required=""  style="cursor: pointer;">
                      <option value=""> -Select- </option>
                      <?php 
                        include 'dbCon.php';
                        $con = connect();
                        $sql = "SELECT * FROM `locations`;";
                        $result = $con->query($sql);
                        foreach ($result as $r) {
                      ?>
                        <option value="<?php echo $r['id']; ?>"><?php echo $r['location_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <input type="submit" class="search-submit btn btn-primary" name="find" value="Find">  
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="map"></div>

    <script type="text/javascript">
    function initMap() {
      const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: { lat: 14.642664, lng: 120.477945 },
      });

      setMarkers(map);
    }
    const restaurantlocation = [

    <?php 
        $con = connect();
        $sql = "SELECT * FROM `restaurant_info` WHERE role=1 and approve_status=1";
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
  </script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw9lahq_sYashBHjt3ucPX5IfNZYDJwlc&callback=initMap"></script>

    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <span class="subheading"></span>
            <h2>Restaurants Near You</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 dish-menu">


            <div class="tab-content py-5" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="row">
                  <?php  
                  if (isset($_POST['bookdeli'])) {
                    $_SESSION['isLoggedIn'] = TRUE;
                    $location = $_SESSION['location'];
                    $con = connect();
                    $sql = "SELECT * FROM `restaurant_info` WHERE location = '$location' and role=1 and approve_status=1;";
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
                            <p>Rating: </p>
                          </div>
                        </div>
                        <div class="one-third">
                        	<a href="reservation.php?res_id=<?php echo $r['id']; ?>" class="btn btn-info" style="width: 100%;margin-left: 23px;margin-top: 18px;">Book Table</a>
                          <a href="delivery.php?res_id=<?php echo $r['id']; ?>" class="btn btn-info" style="width: 100%;margin-left: 23px;margin-top: 18px;">Pick-Up</a>
                          <a href="starrate.php?res_id=<?php echo $r['id']; ?>" class="btn btn-info" style="width: 100%;margin-left: 23px;margin-top: 18px;">Feedback</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php }
                  }
                  else{
                    echo "<p align='center'>No Nearby Restaurants</p>";
                  } ?>
              </div><!-- END -->
            </div>
          </div>
        </div>
      </div>
    </section>
   

    <?php include 'template/font-menu.php'; ?>  
    <br>
    <div id="about">
    <br><br><br><br><br><br>
    <section class="ftco-section bg-light">
      <div class="container special-dish"> 
           
            <h3 style="text-align: center;">Samgyupsal Resto Booking System</h3> 
            Samgyeopsal Restaurant Management Portal with 2D Mapping is a web-based system that will help the different samgyeopsal restaurants in the Province of Bataan. 
            Not only it can help the restaurants, it can also provide to the users a better and easier way of transacting to the restaurants. 
            Users can order food via pick-up option and can book for a reservation in a restaurant. With the help of 2D mapping, the users can find different samgyeopsal restaurants near their location. 
            Another technology integrated in the system is the SMS notifications. With this technology, the restaurants can confirm or cancel orders and bookings and the system will notify the users via SMS or a text message.
      </div>
    </section>

    <style>
       @import url('https://fonts.googleapis.com/css?family=Allura|Josefin+Sans');

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body{
  background: #;
  font-family: 'Josefin Sans', sans-serif;
}

.wrapper{
  margin-top: 50px;
}

.wrapper h1{
  font-family: 'Allura', cursive;
  font-size: 52px;
  margin-bottom: 60px;
  text-align: center;
}

.team{
  display: flex;
  justify-content: center;
  width: auto;
  text-align: center;
  flex-wrap: wrap;
}

.team .team_member{
  background: #fff;
  margin: 5px;
  margin-bottom: 50px;
  width: 300px;
  padding: 20px;
  line-height: 20px;
  color: #8e8b8b;  
  position: relative;
}

.team .team_member h3{
  color: #FFB400;
  font-size: 26px;
  margin-top: 50px;
}

.team .team_member p.role{
  color: #ccc;
  margin: 12px 0;
  font-size: 12px;
  text-transform: uppercase;
}

.team .team_member .team_img{
  position: absolute;
  top: -50px;
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: #fff;
}

.team .team_member .team_img img{
  width: 100px;
  height: 100px;
  padding: 5px;
  border-radius: 50%;
}

    </style>

<script>//https://colorlib.com/polygon/adminator/index.html</script>
<p align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/vkUX1u8YpDw?playlist=vkUX1u8YpDw&loop=1&autoplay=1&mute=1"  frameborder="0" allow="autoplay;" allowfullscreen loop></iframe>
</p>
</div>
<div class="wrapper">
  <h1>Our Team</h1>
  <div class="team">
    <div class="team_member">
      <div class="team_img">
        <img src="tean/kirk.jpg" alt="Team_image">
      </div>
      <h3>Kirk Manansala</h3>
      <p class="role">Lead Programmer</p>
      <h4>BSIT NW 4C<br>
          Pilar, Bataan<br>
          kirkbernabe@gmail.com<br>
          09301226407</h4>
      
    </div>
    <div class="team_member">
      <div class="team_img">
        <img src="tean/gen.jpg" alt="Team_image">
      </div>
      <h3>Gen-lyn Lampano</h3>
      <p class="role">Lead UI Designer/Tester</p>
      <h4>BSIT NW 4C<br>
          Hermosa, Bataan<br>
          genlampano31@gmail.com<br>
          09094746073</h4></div>


    <div class="team_member">
      <div class="team_img">
        <img src="tean/jhai.jpg" alt="Team_image">
      </div>
      <h3>Jhairra Mae Molina</h3>
      <p class="role">Team Leader/Tester</p>
      <h4>BSIT NW 4C<br>
          Balanga City, Bataan<br>
          jcalmamolina@gmail.com<br>
          09212311243</h4>
    </div>
    <div class="team_member">
      <div class="team_img">
        <img src="tean/jayr.jpg" alt="Team_image">
      </div>
      <h3>Jay-R Magtaan</h3>
      <p class="role">Assistant Programmer/Tester</p>
      <h4>BSIT NW 4C<br>
          Dinalupihan, Bataan<br>
          jayrmagtaan26@gmail.com<br>
          09517847025</h4>    
    </div>
    <div class="team_member">
      <div class="team_img">
        <img src="tean/harvs.jpg" alt="Team_image">
      </div>
      <h3>Harvie Mariez Pedrosa</h3>
      <p class="role">Assistant UI Designer/Tester</p>
      <h4>BSIT NW 4C<br>
      Mariveles, Bataan<br>
      pedrosaharvie@gmail.com<br>
      09455877455</h4>
    </div>
  </div>
</div>
</div>

  <?php include 'template/footer.php'; ?>


  <?php include 'template/script.php'; ?>
  
  <script src="dashboard/assets/vendor/jquery/jquery.js"></script>
  <script src="dashboard/assets/vendor/select2/select2.js"></script>
  <script src="dashboard/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
    
  </body>
</html>