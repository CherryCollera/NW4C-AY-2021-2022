
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="Stylesheet.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="userhome.css"/>
</head>
<style>
.aboutinfo{
    color: white;
	border-radius: 15%;
    cursor: pointer;
    width: 10vh;
    position: fixed;
    height: 10vh;
    font-size: 50px;
    font-weight: 600;
    bottom: 0;
    right: 0;
    transition: 350ms ease-in-out;
}

.aboutinfo:hover{
    color: black;
    transition: 350ms ease-in-out;
}
</style>
<body>
   <nav id="navigation" >
        <d class='userAdmtxt'><form action="mainSearch.php" method="POST" class='navUSerHome'><input name='userSearch' placeholder='Search here...' type='text' /><button name='btnuserSearch' type='submit' ><i class="fas fa-search"></i></button></form></d>
        <img  title='Home'  class='navUL' onclick="window.location.href='main.php'" style='cursor:pointer' src='BMCP.png' class='userAdmtxt' alt='log'/>
        <ul id="log">
            <li><a class='regh' href="register.php">Register</a></li>
            <li><a class='logh' href="log-in.php">Log-in</a></li>
        </ul>
    </nav>
    
    <div class='userHomeProdDiv'>
<div class='userHomeProd-wrapper'>
<div class='new-wrapper'>
    <div class='headerTable'><h1>Hot Products</h1><a>View All</a></div>
    <div class='products-wraper'>
    </div>
</div>

<div class='new-wrapper'>
    
    <div class='products-wraper'>
<?php 
  $connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
 $sql = "SELECT * FROM product_desc WHERE product_id > 12 &&  product_id < 22";
 $result = mysqli_query($connection, $sql);
 if (mysqli_num_rows($result)>0){
while($row = mysqli_fetch_array($result)){
$sql2 = "SELECT * FROM product_value WHERE product_id = ".$row['product_id']."";
$result2 = mysqli_query($connection, $sql2);

while($row2 = mysqli_fetch_array($result2)){
echo '<div class="prodInfo" title="'.$row["prod_name"].'">
<img src="'.$row["prod_img"].'" alt="product"/>
<p style="font-weight: 800">'.$row["prod_name"].'</p>
<p>'.$row["brand_name"].'</p>
<p>Rating</p>
<p>₱ '.$row2["s_price"].'.00</p>
<form action="mainAct.php" method="POST" class="prodDivbtns">';
    
    if (mysqli_num_rows($result2)>0){
    echo'<button type="submit" class="regh" name="UnCartBtn">Added to Cart</button>';
    }else{
    echo'<button type="submit" class="logh" name="BuyBtn">Add to Cart</button>';
    }
    echo'<button type="submit" class="regh" name="DetaBtn">Details</button>
    </form>
    </div>
';
    }
}
}else{
echo"<div class='noProd'>No Products</div>";
}
?>
    </div>
</div>

<div class='new-wrapper'>
    <div class='headerTable'><h1>Featured Products</h1><a>View All</a></div>
    <div class='products-wraper fixa'>
<?php 
  $connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
 $sql = "SELECT * FROM product_desc";
 $result = mysqli_query($connection, $sql);
 if (mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result)){
    $sql2 = "SELECT * FROM product_value WHERE product_id = ".$row['product_id']."";
    $result2 = mysqli_query($connection, $sql2);
    
    while($row2 = mysqli_fetch_array($result2)){
    echo '<div class="prodInfo" title="'.$row["prod_name"].'">
    <img src="'.$row["prod_img"].'" alt="product"/>
    <p style="font-weight: 800">'.$row["prod_name"].'</p>
    <p>'.$row["brand_name"].'</p>
    <p>Rating</p>
    <p>₱ '.$row2["s_price"].'.00</p>
    <form action="mainAct.php" method="POST" class="prodDivbtns">';
    
    if (mysqli_num_rows($result2)>1){
    echo'<button type="submit" class="regh" name="UnCartBtn">Added to Cart</button>';
    }else{
    echo'<button type="submit" class="logh" name="BuyBtn">Add to Cart</button>';
    }
    echo'<button type="submit" class="regh" name="DetaBtn">Details</button>
    </form>
    </div>
    ';
        }
    }
    }else{
    echo"<div class='noProd'>No Products</div>";
    }
    ?>
    </div>
</div>

        </div>
    </div>

    <div>
        <div title='About' ><a href="about.php" class='aboutinfo fixd' id='info' name='info' ><i class='fas fa-info-circle'></i></a>
    </div>

</body>
</html>