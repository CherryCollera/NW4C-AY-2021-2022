

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
</head>
<style>
    </style>
<body>
<nav id="navigation" >
        <ul class='navUL'>
            <li class='navLI'><a class="navA" href="index.php">Home</a></li>
            <li class='navLI'><a class="navA" href="about.php">About</a></li>
            <li class='navLI'><a class="navA" href="products.php">Products</a></li>
        </ul>
        <ul id="log">
            <li><a class='regh' href="register.php">Register</a></li>
            <li><a class='logh' href="log-in.php">Log-in</a></li>
        </ul>
    </nav>

  <?php
  
  $connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');

  $sql = "SELECT * FROM brand_names";
  $result = mysqli_query($connection, $sql);

  if (mysqli_num_rows($result)>0){
      
      while($row = mysqli_fetch_array($result)){
          echo "<p style='color:white; text-align: center; transform:translate(0%, 0%);'>" . $row['bname'];
          echo "<br>";
          echo "<br>";
          echo "<img src= '".$row['logo']."'class='center'
          stlyle='width: 400px; heigth: 400px;'>";
          echo "<br>";
          
         
      }
  }
  
  ?>

</body>
</html>