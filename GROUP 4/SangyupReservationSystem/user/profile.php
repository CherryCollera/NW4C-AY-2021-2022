<!-- booking-list.php -->
<?php include 'template/header.php'; 
if (!isset($_SESSION['isLoggedIn'])) {
  echo '<script>window.location="login.php"</script>';
}

?>


  <body> 

      <!-- start: header -->
      <?php include 'template/top-bar.php'; ?>
      <!-- end: header -->

      <div class="inner-wrapper">
        <!-- start: sidebar -->
        <?php include 'template/left-bar.php'; ?>
        <!-- end: sidebar --> 
        <section role="main" class="content-body">
          <header class="page-header">
            <h2>Modify Account</h2>
          
            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="index.php">
                    <i class="fa fa-home"></i>
                  </a>
                </li>
                <li><span>Profile</span></li> 
              </ol>
          
              <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
            </div>
          </header>

          <!-- start: page -->
            
          <section>
            
                <?php

                // SELECT `id`, `restaurent_name`, `email`, `phone`, `address`, `location`, `logo`, `password`, `bkashnumber`, `approve_status`, `role` FROM `restaurant_info` WHERE 1

                include 'dbCon.php';
                $con = connect();
                $res_id = $_SESSION['id']; 
                $res_pass = $_SESSION['password'];

                $sql = "SELECT * FROM `restaurant_info` where id = '$res_id';";
                $result = $con->query($sql);
                $row =  mysqli_fetch_assoc($result);


                if (isset($_POST['save'])) {
                  $current_password = $_POST['current_password'];
                  if($current_password == $res_pass){
                    # code...
                    $sql = "UPDATE `restaurant_info` SET `restaurent_name`='".$_POST['fullname']."',`email`='".$_POST['email']."',`phone`='".$_POST['phone']."',`address`='".$_POST['address']."',`location`='".$_POST['area']."',`password`='".$_POST['password']."' WHERE `id`='$res_id'";
                    $cur = $con->query($sql);
                    if ($cur) {
                      # code...
                      echo '<script>alert("Accounts has been updated.")</script>';
                      echo '<script>window.location="../logout.php"</script>';
                    }
                  }else{
                      echo '<script>alert("Incorrect Password.")</script>';
                      echo '<script>window.location="profile.php"</script>';
                  }
                }

                if (isset($_POST['savephoto'])) { 
                    $targetDirectory = "user-image/";
            // get the file name
                    $file_name = $_FILES['image']['name'];
                    // get the mime type
                    $file_mime_type = $_FILES['image']['type'];
                    // get the file size
                    $file_size = $_FILES['image']['size'];
                    // get the file in temporary
                    $file_tmp = $_FILES['image']['tmp_name'];
                    // get the file extension, pathinfo($variable_name,FLAG)
                    $extension = pathinfo($file_name,PATHINFO_EXTENSION);

                    //register as customer
                    if ($extension =="jpg" || $extension =="png" || $extension =="jpeg"){
                      move_uploaded_file($file_tmp,$targetDirectory.$file_name);
                        $sql = "UPDATE `restaurant_info` SET `logo`='".$file_name."' WHERE `id`='$res_id'"; 
                        if ($con->query($sql) === TRUE) {
                          echo '<script>alert("Logo has been updated")</script>';
                          echo '<script>window.location="profile.php"</script>';
                        }else {
                              echo "Error: " . $sql . "<br>" . $con->error;
                          }
                      
                    }else{
                      echo '<script>alert("Required JPG,PNG,GIF in Logo Field.")</script>';
                        echo '<script>window.location="profile.php"</script>';
                    }
                }
                 
                 ?>
<style type="text/css">
.stretch {
    margin-top: 5px;
}
.stretch img{ 
 width: 100%; 
 cursor: pointer;
} 
</style>

  <div class="contanier"> 
    <div class="row">

        
        <div class="col-lg-9"> 
    <form class="form-horizontal" method="POST" action="profile.php">  
      <div class="row">    

              <div class="form-group">
                <div class="col-md-7">
                <label class="col-md-4 control-label" for=
                  "Fname">Name:</label>

                  <div class="col-md-8">
                   <input type="text" name="fullname" class="form-control" required="" placeholder="Restaurant Name" value="<?php echo $row['restaurent_name'];?>">
                  </div>
                </div>
              </div> 

              <div class="form-group">
                <div class="col-md-7">
                <label class="col-md-4 control-label" for=
                  "Lname">Email Address:</label>

                  <div class="col-md-8"> 
                     <input type="email" name="email" class="form-control" required="" placeholder="Restaurant Email" value="<?php echo $row['email'];?>">
                  </div>
                </div>
              </div> 

              <div class="form-group">
                <div class="col-md-7">
                  <label class="col-md-4 control-label" for=
                  "CustomerContact">Current Password:</label>

                  <div class="col-md-8">
                     <input type="password" name="current_password" class="form-control" required="" placeholder="Password" value="">
                  </div>
                </div>
              </div>  

               <div class="form-group">
                <div class="col-md-7">
                  <label class="col-md-4 control-label" for=
                  "CustomerContact">Password:</label>

                  <div class="col-md-8">
                     <input type="password" name="password" class="form-control" required="" placeholder="Password" value="">
                  </div>
                </div>
              </div>   

             <div class="form-group">
                <div class="col-md-7">
                  <label class="col-md-4 control-label" for=
                  "CustomerContact"></label>

                  <div class="col-md-8">
                         <input type="submit" value="Save" name="save" class="btn btn-primary py-3 px-5">
                  </div>
                </div>
              </div> 

        
          </div>  
           </form>  
           
        </div><!--/col-sm-9-->
    </div><!--/row--> 
  </div><!--/contanier--> 
          </section>
                 
           
            
            
          <!-- end: page -->
        </section>
      </div>

      <?php include 'template/right-bar.php'; ?>  

    <?php include 'template/script-res.php'; ?>
  </body>
</html>



<div class="modal fade" id="logomodal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal" type=
                                    "button">x</button>

                                    <h4 class="modal-title" id="myModalLabel">Image.</h4>
                                </div>

                                <form action="profile.php" enctype="multipart/form-data" method=
                                "post">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="rows">
                                                <div class="col-md-12">
                                                    <div class="rows">
                                                        <div class="col-md-8"> 
                                                            <input class="mealid" type="hidden" name="mealid" id="mealid" value="">
                                                              <input name="MAX_FILE_SIZE" type="hidden" 
                                                              value="1000000"> 
                                                              <input id="image" name="image" type="file">
                                                        </div>

                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-default" data-dismiss="modal" type=
                                        "button">Close</button> <button class="btn btn-primary"
                                        name="savephoto" type="submit">Upload Photo</button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content-->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->  