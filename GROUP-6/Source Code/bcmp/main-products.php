<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="userhome.css"/>
    <link rel="stylesheet" type="text/css" href="user-products.css"/>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>
<style>
    </style>
<body>
   
<nav id="navigation" >
<d class='userAdmtxt'><form action="mainSearch.php" method="POST" class='navUSerHome'><input name='userSearch' placeholder='Search here...' type='text' /><button type='submit' ><i class="fas fa-search"></i></button></form></d>
        <img  title='Home'  class='navUL' onclick="window.location.href='main.php'" style='cursor:pointer' src='BMCP.png' class='userAdmtxt' alt='log'/>
       
        <ul id="log">
            <li><a class='regh' href="register.php">Register</a></li>
            <li><a class='logh' href="log-in.php">Log-in</a></li>
        </ul>
    </nav>
    <div class='userHomeProdDiv'>
        <div class='userHomeProd-wrapper'>
            <form action="mainSearch.php" method="POST" class='cate-wrapper'>
                <button class='cate_btn' id='All' name='btnCategory' value=''><i class="fas fa-list-ul"></i> All</button><div class='vr'></div>
                <button class='cate_btn'  id='Bottoms' name='btnCategory' value='Bottoms'><i class="fas fa-search"></i> Bottoms</button><div class='vr'></div>
                <button class='cate_btn'  id='Caps' name='btnCategory' value='Caps'><i class="fas fa-search"></i> Caps</button><div class='vr'></div>
                <button class='cate_btn'  id='Hoodie' name='btnCategory' value='Hoodie'><i class="fas fa-search"></i> Hoodie</button><div class='vr'></div>
                <button class='cate_btn' id='Jacket' name='btnCategory' value='Jacket'><i class="fas fa-search"></i> Jacket</button><div class='vr'></div>
                <button class='cate_btn'  id='Shoes' name='btnCategory' value='Shoes'><i class="fas fa-search"></i> Shoes</button><div class='vr'></div>
                <button class='cate_btn'  id='Shorts' name='btnCategory' value='Shorts'><i class="fas fa-search"></i> Shorts</button><div class='vr'></div>
                <button class='cate_btn'   id='Tops' name='btnCategory' value='Tops'><i class="fas fa-search"></i> Tops</button><div class='vr'></div>
                <button class='cate_btn'  id='Others' name='btnCategory' value='Others'><i class="fas fa-search"></i> Others</button>
            </form>
            
<div class='new-wrapper'>
    <div class='products-wraper fixa'>
<?php 
  $connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
//  $sql = "SELECT * FROM product_desc";
 $result = mysqli_query($connection, $_SESSION['sql_search']);
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
</body>
<script>
window.addEventListener("load", startup, false);
function startup() {
    var cate = "#"+'<?php echo"$_SESSION[search_Category]" ?>';
    btn = document.querySelector(cate);
    btn.className = 'cate_btn oni'
}

</script>
</html>