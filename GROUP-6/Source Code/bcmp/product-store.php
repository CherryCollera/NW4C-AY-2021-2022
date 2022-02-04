<?php

session_start();
if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}
// unset($_SESSION["timestamp"]);

// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="Stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="userhome.css"/>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="userprofile.css"/>
    <link rel="stylesheet" type="text/css" href="sellerprofile.css"/>
</head>
<body>
<nav id="navigation" >
        <div onclick='showD()'  class='backBtn'><i class="fas fa-angle-left iconBack"></i> 
         Back</div>
        <img  title='Home'  class='navUL' onclick="window.location.href='userhome.php'" style='cursor:pointer' src='BMCP.png' class='userAdmtxt' alt='log'/>
        <ul id="log">
            <li title='Profile' ><a class='regh' style="padding:4.5px 25px" href="userProfileAct.php"><?php echo"Welcome " . $_SESSION['name'] ?><i class="fas fa-user-tie iconAdmin"></i></a></li>
            <li title='Log-out' ><a class='logh'href="userlogout.php">Log-out</a></li>
        </ul>
    </nav>
    <div class='profile_div'>
    <div class='profile_content'>
    <form method='POST' action='seller-storeAct.php' class='btn_store'>
        <button id='btn_store' name='btn_store' type='submit' value='report' class=' btn_store_IC regh'><i title='report' class='fas fa-exclamation-circle' ></i></button>
        <button id='btn_store' name='btn_store' type='submit' value='feedback' class=' btn_store_IC regh'><i title='feedback' class='fas fa-bullhorn' ></i></button>
        </form>
        <?php 
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
            $sql = "SELECT * FROM product_desc where product_id = '".$_SESSION['product_id']."'";
            $result = mysqli_query($connection2, $sql);
            $brand = mysqli_fetch_array($result);
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
                $sq = "SELECT * FROM brand_names where brand_id = '".$brand['brand_id']."'";
                $resu = mysqli_query($connection2, $sq);
                        $seller = mysqli_fetch_array($resu);
                        $_SESSION['seller_id'] = $seller['seller_id'];
                        $_SESSION['seller_name'] = $seller['seller_name'];
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
                    $s = "SELECT * FROM seller where id = '".$_SESSION['seller_id']."'";
                    $res = mysqli_query($connection2, $s);
                            $sellerData = mysqli_fetch_array($res);
                    echo  "
        <i class='fas fa-user-tie userIcon' ></i>
        <p class='userName'>".$sellerData['owner_name']."</p>
        <p class='userDetails'> <i class='fas fa-envelope detaIC' ></i>".$sellerData['email']."</p>
        <p class='userDetails'><i class='fas fa-phone-alt detaIC' ></i>".$sellerData['cnumber']."</p>
                    ";
        ?>
    </div>
    <div class='hr'></div>
    <form action="seller-storeAct.php" method="POST" class='transaction_btn'>
            <button name='tranBtn' id='Best' value='Best' class='transactBtn' type='submit'><i class='fas fa-star'></i>Best Sellers</button>
            <button name='tranBtn' id='All' value='All' class='transactBtn' type='submit'><i class='fas fa-border-all'></i>All Products</button>
            <button name='tranBtn' id='Feed' value='Feed' class='transactBtn' type='submit'><i class='fas fa-bullhorn'></i>Feedbacks</button>
        </form>
    <div class='hr'></div>
    <div class='classCon'> 

<?php
$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
if($_SESSION['showUsers'] == 'Best'){
$connect = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql = "SELECT * FROM brand_names WHERE seller_id = ".$_SESSION['seller_id']."";
    $result = mysqli_query($connect, $sql);
   if (mysqli_num_rows($result)>0){
       while($row = mysqli_fetch_array($result)){
        echo"
        <h1 style='margin-bottom:-10px;'>Best Sellers</h1>
        <div class='hr'></div>
        <div class='products-wraper'>";
$sql = "SELECT * FROM order_list WHERE seller_id = ".$_SESSION['seller_id']." && status = 'Recieved'";
 $result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result)>0){
while($row = mysqli_fetch_array($result)){
            $sq = "SELECT * FROM product_desc WHERE product_id = ".$row['product_id']."";
            $resu = mysqli_query($connection, $sq);
            if (mysqli_num_rows($resu)>0){
                while($row = mysqli_fetch_array($resu)){
                    $s = "SELECT * FROM product_value WHERE brand_id = ".$row['brand_id']."";
                    $res = mysqli_query($connection, $s);
                    if (mysqli_num_rows($resu)>0){
                        $row2 = mysqli_fetch_array($res);
                            echo '<div class="prodInfo" title="'.$row["prod_name"].'">
                            <img src="'.$row["prod_img"].'" alt="product"/>
                            <p style="font-weight: 800">'.$row["prod_name"].'</p>
                            <p>'.$row["brand_name"].'</p>
                            <p>Rating</p>
                            <p>₱ '.$row2["s_price"].'.00</p>
                            <form action="prodAct.php" method="POST" class="prodDivbtns">';

                            $sql3 = "SELECT * FROM product_cart WHERE product_id = ".$row['product_id']." && user_id = ".$_SESSION['user_id']."";
                            $result3 = mysqli_query($connection, $sql3);
                            if (mysqli_num_rows($result3)>0){
                            echo'<button type="submit" class="regh" value="'.$row["product_id"].'" name="UnCartBtn">Added to Cart</button>';
                            }else{
                            echo'<button type="submit" class="logh" value="'.$row["product_id"].'" name="BuyBtn">Add to Cart</button>';
                            }
                            echo'<button type="submit" class="regh" value="'.$row2["product_id"].'" name="DetaBtn">Details</button>
                            </form>
                            </div>
                        ';
                        
                    }        

                }
            }
            }
            }
        echo"
        </div>
        <div class='hr'></div>";

       }
   }else{
    echo "<div class='nor'>No Brands</div>";
   }



}else if($_SESSION['showUsers'] == 'All'){
$connect = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql = "SELECT * FROM brand_names WHERE seller_id = ".$_SESSION['seller_id']."";
    $result = mysqli_query($connect, $sql);
   if (mysqli_num_rows($result)>0){
       while($row = mysqli_fetch_array($result)){
        echo"
        <h1 style='margin-bottom:-10px;'>".$row['brand_name']."</h1>
        <div class='hr'></div>
        <div class='products-wraper'>";
            $sq = "SELECT * FROM product_desc WHERE brand_id = ".$row['brand_id']."";
            $resu = mysqli_query($connection, $sq);
            if (mysqli_num_rows($resu)>0){
                while($row = mysqli_fetch_array($resu)){
                    $s = "SELECT * FROM product_value WHERE brand_id = ".$row['brand_id']."";
                    $res = mysqli_query($connection, $s);
                    if (mysqli_num_rows($resu)>0){
                        $row2 = mysqli_fetch_array($res);
                            echo '<div class="prodInfo" title="'.$row["prod_name"].'">
                            <img src="'.$row["prod_img"].'" alt="product"/>
                            <p style="font-weight: 800">'.$row["prod_name"].'</p>
                            <p>'.$row["brand_name"].'</p>
                            <p>Rating</p>
                            <p>₱ '.$row2["s_price"].'.00</p>
                            <form action="prodAct.php" method="POST" class="prodDivbtns">';

                            $sql3 = "SELECT * FROM product_cart WHERE product_id = ".$row['product_id']." && user_id = ".$_SESSION['user_id']."";
                            $result3 = mysqli_query($connection, $sql3);
                            if (mysqli_num_rows($result3)>0){
                            echo'<button type="submit" class="regh" value="'.$row["product_id"].'" name="UnCartBtn">Added to Cart</button>';
                            }else{
                            echo'<button type="submit" class="logh" value="'.$row["product_id"].'" name="BuyBtn">Add to Cart</button>';
                            }
                            echo'<button type="submit" class="regh" value="'.$row2["product_id"].'" name="DetaBtn">Details</button>
                            </form>
                            </div>
                        ';
                        
                    }        

                }
            }
        echo"
        </div>
        <div class='hr'></div>";

       }
   }else{
    echo "<div class='nor'>No Brands</div>";
   }

}


?>
    </div>
</body>
<script>

function showD(){
    window.location.href='product-details.php';
}
window.addEventListener("load", startup, false);
function startup() {
    var cate = "#"+'<?php echo"$_SESSION[showUsers]" ?>';
    btn = document.querySelector(cate);
    btn.className = 'transactBtn one'
}
</script>
</html>