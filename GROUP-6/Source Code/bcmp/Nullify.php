<?php


session_start();



if(!isset($_SESSION['brandname'])){
    header("Location: log-in.php");
}

$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');

if(isset($_POST['save'])){
    $name = $_POST['nop'];
    $image = $_POST['img'];
    $ss = $_POST['ss'];
    $sm = $_POST['sm'];
    $sl = $_POST['sl'];
    $sxl = $_POST['sxl'];
    $price = $_POST['price'];
    
$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
    $sql = "SELECT * FROM nullify WHERE name='$name'";
        $result = mysqli_query($connection, $sql);
    if ($name == $_POST['nop']){
        $sql = "SELECT * FROM nullify WHERE name='$name'";
        $result = mysqli_query($connection, $sql);
        if ($result -> num_rows < 10){
            $sql = "INSERT INTO nullify (name, image, size_small, size_medium, size_large, size_xlarge, price)
                VALUES ('$name', '$image', $ss, $sm, $sl,$sxl,'$price')";
            $result = mysqli_query($connection, $sql);
            if ($result){
                echo "<script>alert('Product Added.')</script>";
                $name = "";
                $image = "";
                $ss = "";
                $sm = "";
                $sl = "";
                $sxl = "";
                $price = "";
            } else {
                echo "<script>alert('Something Went Wrong.')</script>";
            }
        } else {
            echo "<script>alert('Error occured.')</script>";
        }  
    } else {
        echo "<script>alert('Error')</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<style>
    </style>
<body>
    <div id="wrapper">
        <div id="banner">
   </div>   
   
   <nav id="navigation" >
        <ul id="nav">
            <li><a href="sellerhome.php">Home</a></li>
            <li><a href="sellerabout.php">About</a></li>
            <li><a href="sellerproducts.php">Products</a></li>
        </ul>
        <ul id="log">
            <li><?php echo "Welcome " . $_SESSION['brandname'];?></li>
            <li><a href="sellerlogout.php">Logout</a></li>
        </ul>
    </nav>
    
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title" color:white; style=" transform:translate(2%, -150%);">Add New Product</h4>
      </div>
      <div class="modal-body"> <form method="POST" style=" transform:translate(-2%, -15%);" >
        <div style="width: 77%;margin: auto;">
         
          <div class="form-group">
            <label for="some" class="col-form-label"  color:white;>Name</label>
            <input type="text" name="nop" class="form-control" id="some" required>
          </div>
          <div class="form-group">
            Sizes:  <label for="some" class="col-form-label"  color:white;>Small</label>
            <input type="text" name="ss" class="form-control" id="some" style="width: 30px;">
          </div>
          <div class="form-group">
            <label for="some" class="col-form-label"  style=" transform:translate(5%, -130%);" >Medium</label>
            <input type="text" name="sm" class="form-control" id="some" style="width: 30px; ">
          </div>
          <div class="form-group">
            <label for="some" class="col-form-label"  style=" transform:translate(5%, -130%);" >Large</label>
            <input type="text" name="sl" class="form-control" id="some" style="width: 30px; ">
          </div>
          <div class="form-group">
            <label for="some" class="col-form-label"  style=" transform:translate(5%, -130%);" >X-Large</label>
            <input type="text" name="sxl" class="form-control" id="some" style="width: 30px; ">
          </div>
          <div class="form-group">
            <label for="some" class="col-form-label"  color:white;>Price</label>
            <input type="text" name="price" class="form-control" id="some" style="width: 50px; " required>
          </div>
          <div class="form-group">
            <label for="some" class="col-form-label">Product Image</label>
            <input type="file" name="img" class="form-control" id="some" required>
          </div>
          <div class="form-group">
        <button type="submit" class="btn btn-primary" name="save">Add Product</button>
        </div>
          
        </div>
      </div>
      
    </form>
    </div>

  </div>
</div> 

<?php 

$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');

    $sql = "SELECT * FROM nullify";
    $result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result)>0){
        
    while($row = mysqli_fetch_array($result)){
        echo '<div class="image" >';
        echo "<img src= '".$row['image']."'class='center' 
        stlyle='width: 400px; heigth: 400px;'>";
        echo '</div>';
        echo '<div class="info">';
        echo '<form action="" method="POST" class="login-email">';
      
        echo "Product Name";
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "Small";
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "Medium";
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "Large";
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "XLarge";
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "Price";
        echo '</form>';
        echo '</div>';

        echo "<p style='color:white; text-align: center; transform:translate(-19%, 15%);'>" . $row['name'] ;
        
        echo "<p style='color:white; text-align: center; transform:translate(-10%, -171%);'>" . $row['size_small'] ;
        echo "<p style='color:white; text-align: center; transform:translate(-2%, -355%);'>" . $row['size_medium'] ;
        echo "<p style='color:white; text-align: center; transform:translate(6%, -535%);'>" . $row['size_large'] ;
        echo "<p style='color:white; text-align: center; transform:translate(14%, -720%);'>" . $row['size_xlarge'];
        echo "<p style='color:white; text-align: center; transform:translate(21%, -900%);'>" . $row['price'];
        
        
       
    }
}

?>

</body>
</html>