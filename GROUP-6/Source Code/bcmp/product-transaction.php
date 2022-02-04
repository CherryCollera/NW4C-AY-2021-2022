  <?php

session_start();

require 'vendor/autoload.php';
require 'config-cloud.php';

if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}
$_POST['prod_id'] = $_SESSION['product_id'];
// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql1 = "SELECT * FROM product_desc where product_id ='".$_POST['prod_id']."' ";
$result1 = mysqli_query($connection2, $sql1);
if (mysqli_num_rows($result1)>0){
  while($row = mysqli_fetch_array($result1)){
    $_POST['prod_name'] = $row['prod_name'];
    $_POST['prod_img'] = $row['prod_img'];
    $_POST['prod_color'] = $row['prod_color'];
    $_POST['prod_gend'] = $row['prod_gend'];
    $_POST['prod_type'] = $row['prod_type'];
    $_POST['prod_desc'] = $row['prod_desc'];
    $_POST['brand_name'] = $row['brand_name'];
    $_POST['brand_id'] = $row['brand_id'];
  }
}else{
  echo"<script>alert('No Product Fetched');</script>";
}

$sql2 = "SELECT * FROM product_value where product_id ='".$_POST['prod_id']."' ";
$result2 = mysqli_query($connection2, $sql2);
if (mysqli_num_rows($result2)>0){
  while($row = mysqli_fetch_array($result2)){
    $_POST['small'] = $row['small'];
    $_POST['medium'] = $row['medium'];
    $_POST['large'] = $row['large'];
    $_POST['x_large'] = $row['x_large'];
    $_POST['s_price'] = $row['s_price'];
    $_POST['m_price'] = $row['m_price'];
    $_POST['l_price'] = $row['l_price'];
    $_POST['xl_price'] = $row['xl_price'];
  }
}else{
  echo"<script>alert('No Product Fetched');</script>";
}

$sql3 = "SELECT * FROM order_list where order_id ='".$_SESSION['order_id']."' ";
$result3 = mysqli_query($connection2, $sql3);
if (mysqli_num_rows($result3)>0){
  while($row = mysqli_fetch_array($result3)){
    $_POST['status'] = $row['order_id'];
    $_POST['buy_date'] = $row['buy_date'];
    $_POST['accept_date'] = $row['accept_date'];
    $date = strtotime($_POST['accept_date']);
    $date = strtotime("+7 day", $date);
    $_POST['est_date'] = date('Y-m-d H:i:s', $date);
    $_POST['packed_date'] = $row['packed_date'];
    $_POST['ship_date'] = $row['ship_date'];
    $_POST['cancel_date'] = $row['cancel_date'];
    $_POST['recieve_date'] = $row['recieve_date'];
    $_POST['prod_size'] = $row['prod_size'];
    $_POST['prod_quantity'] = $row['prod_quantity'];
    $_POST['prod_price'] = $row['prod_price'];
    $_POST['deliver_loc'] = $row['deliver_loc'];
  }
}else{
  echo"<script>alert('No Product Fetched');</script>";
}

$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql3 = "SELECT * FROM brand_names where brand_id ='".$_POST['brand_id']."' ";
$result3 = mysqli_query($connection, $sql3);
if (mysqli_num_rows($result3)>0){
  while($row = mysqli_fetch_array($result3)){
    $_POST['seller_id'] = $row['seller_id'];
  }
}else{
  echo"<script>alert('No Brand Fetched');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Stylesheet.css"/>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="userhome.css"/>
    <link rel="stylesheet" type="text/css" href="addProduct.css"/>
    <link rel="stylesheet" type="text/css" href="product-details.css"/>
    <script type="text/javascript" src="ntc.js"></script>
</head>
<body>
<nav id="navigation" >
        <div onclick='showD()'  class='backBtn'><i class="fas fa-angle-left iconBack"></i> 
         Back</div>
        <img  title='Home'  class='navUL' onclick="window.location.href='userhome.php'" style='cursor:pointer' src='BMCP.png' class='userAdmtxt' alt='log'/>
        <ul id="log">
            <li title='Profile'><a class='logh' style="padding:4.5px 25px" href="userprofile.php"><?php echo"Welcome " . $_SESSION['name'] ?><i class="fas fa-user-tie iconAdmin"></i></a></li>
            <li title='Log-out'><a class='regh'href="userlogout.php">Log-out</a></li>
        </ul>
    </nav>

    <div class='prod_div' style='margin-bottom:25px;'>
      <div class='prod-warp' >
      <img  class='prodIMG' alt='logo' src="<?php echo "". $_POST['prod_img']; ?>"  />
      </div>
       <div class='prod-warp'> 
         <div style='margin:auto 0;'>
         <p style='margin:auto;'><?php echo "". $_POST['prod_name']; ?></p>
         <a ><?php echo "". $_POST['brand_name']; ?></a>
         <br/>
         <br/>
         <?php 
$usersRated = 0;
$totalRate = 0;
$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql = "SELECT * FROM product_rate where product_id = '".$_SESSION['product_id']."'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result)>0){
  while($row = mysqli_fetch_array($result)){
    $usersRated++;
    $totalRate+=$row['rate_value'];
  }
  $totalRated = $totalRate/$usersRated;
  // echo'<script>console.log('.$totalRated.')</script>';
  echo'
  <label class="rating-label" title="'.$totalRated.'">
  <input
      class="rating"
      max="5"
      readonly
      step="0.01"
      style="--value:'.$totalRated.'"
      type="range"
      value="3"/>
      <span>Rating: '.$totalRated.'<br/> Users-rated: '.$usersRated.'</span>
      </label>
  ';
}else{
echo'
<label class="rating-label">
     Not Rated
      </label>
';
}
?>
      <p class='prodmid'>Description: <?php echo "". $_POST['prod_desc']; ?></p>
      <p id='color' class='prodmid'>sdfsdf</p>
      <p class='prodmid'>Product Type: <?php echo "". $_POST['prod_type']; ?></p>
      <p class='prodmid'>Gender: <?php echo "". $_POST['prod_gend']; ?></p>
      </div>
       </div>
       </div>
       
    <div class='prod_div' style='margin-bottom:25px;'>
    <div class='prod-warp' >
    <div class='prod-price'>
          <p class='prodTail'>Status</p>
          <p style='grid-column: 2/4;' class='prodTail'>Date</p>
          <p class='prodTail'>Ordered</p>
          <p style='grid-column: 2/4;' class='prodmid'><?php echo "". $_POST['buy_date']; ?></p>
          <p class='prodTail'>Accepted</p>
          <p style='grid-column: 2/4;' class='prodmid'><?php echo "". $_POST['accept_date']; ?></p>
          <p class='prodTail'>Packed</p>
          <p style='grid-column: 2/4;' class='prodmid'><?php echo "". $_POST['packed_date']; ?></p>
          <p class='prodTail'>Shipped</p>
          <p style='grid-column: 2/4;' class='prodmid'><?php echo "". $_POST['ship_date']; ?></p>
          <p class='prodTail'>Recieve</p>
          <p style='grid-column: 2/4;' class='prodmid'><?php echo "". $_POST['recieve_date']; ?></p>
          <p class='prodTail'>Canceled</p>
          <p style='grid-column: 2/4;' class='prodmid'><?php echo "". $_POST['cancel_date']; ?></p>
        </div>
    </div>
      
      <div class='prod-warp' >
        <div class='ratings_div'>
            <p style='margin: -5px 0 15px 0;' class='titleRate'>Order Details</p>
            <?php  if($_SESSION['showUsers'] == 'Delivered' || $_SESSION['showUsers'] == 'ToRecieve' || $_SESSION['showUsers'] == 'ToPay' || $_SESSION['showUsers'] == 'ToShip'){ echo "<p style='margin:5px 0;' class='prodmid'>Estimed Deliver Date: ".$_POST['est_date']."</p>"; }?>
      <p style='margin:5px 0;' class='prodmid'>Size: <?php echo "". $_POST['prod_size']; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Quantity: <?php echo "". $_POST['prod_quantity']; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Price: <?php echo "₱ ". $_POST['prod_price'].".00"; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Transaction Type: Cash On Delivery</p>
      <p style='margin:5px 0;' class='prodmid'>Transaction Location: <?php echo "". $_POST['deliver_loc']; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Transaction Fee: ₱ 50.00</p>
      <p style='margin:5px 0;' class='prodmid'>Total Price: <?php echo "₱ ". ($_POST['prod_price'] + 50). '.00'; ?></p>
        </div>
      </div>
      </div>


    
      <?php
        if($_SESSION['showUsers'] == 'Delivered'){
$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql = "SELECT * FROM product_rate where product_id = '".$_SESSION['product_id']."' && order_id = '".$_SESSION['order_id']."' && rater_id = '".$_SESSION['user_id']."'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result)>0){
  while($row = mysqli_fetch_array($result)){
  echo'
  <div class="prod_div" style="margin-top:-50px;">
  <div class="prod-warp" >
  <form  method="post"  enctype="multipart/form-data" action="" class="add_rating">
          <p>Your Feedback</p>
          <p class="prodmid">Your rating for the transaction</p>
          <label class="rating-label fixsa">
          <input
              class="rating"
              max="5"
              readonly
              step="0.01"
              style="--value:'.$totalRated.'"
              type="range"
              value="3"/>
          </label>
          <p class="prodmid">Thoughts you share with us </p>
          <textarea name="rateDesc" class="rating-textarea" readonly>'.$row['rate_desc'].'</textarea>
          <p class="prodmid">Some image you share with us </p>
          <div class="inputTextAddProd" style="grid-column: 9/14; align-items:flex-start;">
            <div class="rateDFiiv-wrapper">
            <div class="rateDFiivText">
            </div>
            <img id="blah" alt="logo" src="'.$row['rateImg'].'" class="rateDi" />
            </div>
            </div>
      </form>
  </div>
    </div>';
          }
}else{
echo'
<div class="prod_div" style="margin-top:-50px;">
<div class="prod-warp" >
<form  method="post"  enctype="multipart/form-data" action="" class="add_rating">
        <p>Feedback</p>
        <p class="prodmid">What do you think about the product ?</p>
        <label class="rating-label fixsa">
          <input
            class="rating rating--nojs"
            max="5"
            step="1"
            name="rateValue"
            type="range"
            required
            value="5"/>
        </label>
        <p class="prodmid">What would you like to share with us ?</p>
        <textarea name="rateDesc" class="rating-textarea" required></textarea>
        <p class="prodmid">Would you like to share some images with us ?</p>
        <div class="inputTextAddProd" style="grid-column: 9/14; align-items:flex-start;">
          <div class="rateDFiiv-wrapper">
          <div class="rateDFiivText">
        <label class="rateLAbelDiov" for="prodAddImage">Image:
          <input type="file" name="prodAddImage" id="prodAddImage" /> </label>
          </div>
          <img id="blah" alt="logo" src="defaul_img.png" class="rateDi" />
          </div>
          </div>
        <button type="submit" class="regh" name="addRateBtn">Submit</button>
    </form>
</div>
  </div>';
}
}

if($_SESSION['showUsers'] == 'Order'){
  echo "<footer>
<form action='product-detailsAct.php' method='POST' class='footer-content'>
  <input name='prod_Size' type='hidden' value='$_POST[prod_size]'/>
  <input name='prod_Quant' type='hidden' value='$_POST[prod_quantity]'/>
   <button type='submit' name='cancelOrdBtn' class='logh'><i class='fas fa-ban'></i>Cancel</button>
</form>
</footer>";
} if($_SESSION['showUsers'] == 'ToRecieve'){
  echo "<footer>
<form action='product-detailsAct.php' method='POST' class='footer-content'>
   <button type='submit' name='recieveOrdBtn' class='logh'><i class='fas fa-dolly'></i>Recieved</button>
   <input name='prod_Size' type='hidden' value='$_POST[prod_size]'/>
   <input name='prod_Quant' type='hidden' value='$_POST[prod_quantity]'/>
</form>
</footer>";
}
        ?>


        <?php
        use Cloudinary\Api\Upload\UploadApi;
if (isset($_POST['addRateBtn'])) {
        $prodImg = $_FILES["prodAddImage"]["name"];
        $filepath = "images/".$_FILES["prodAddImage"]["name"];
        $filename = $_FILES['prodAddImage']['tmp_name'];
        if($filename){
            $img = (new UploadApi())->upload($filename, [
          'public_id' => $prodImg,
          ]
          );
          $imgRate =$img [url];
        }else{
          $imgRate ='';

        }
    $date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
$_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql = "SELECT * FROM product_rate where product_id = '".$_SESSION['product_id']."' && order_id = '".$_SESSION['order_id']."' && rater_id = '".$_SESSION['user_id']."'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result)>0){
    echo "<script>alert('You Can Only Rate Once.')</script>";
}else{

    $sql = "INSERT into product_rate (product_id, order_id, rater_id, rater_name, rate_value, rate_desc, rate_time, rateImg	) value ('$_SESSION[product_id]','$_SESSION[order_id]', '$_SESSION[user_id]','".$_SESSION['name']."', '$_POST[rateValue]', '$_POST[rateDesc]', '$_SESSION[timestamp]', ' $imgRate')";
    if($connection->query($sql)) {
    echo "<script>alert('Product Rated: Thanks for your feedback');</script>";
    }else {
    echo "<script>alert('Error Rate: $connection->error');</script>";
    }

  }
//   echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
echo"<script>window.location.href='userprofile.php' </script>";

}
?>

</body>

<script>
function showD(){
    window.location.href='userprofile.php';
}

window.addEventListener("load", startup, false);
function startup() {
  colorWell = document.querySelector("#color");
  color = '<?php echo"$_POST[prod_color]" ?>';
     var n_match  = ntc.name(color);
    var n_name       = n_match[1]; 
    colorWell.innerHTML = "Color: " + n_name;
}

prodAddImage.onchange = evt => {
  const [file] = prodAddImage.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
    function validateFileType(){
        var fileName = document.getElementById("prodAddImage").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
        }else{
            alert("Only jpg/jpeg and png files are allowed!");
        }   
    }
</script>
</html>


    
<!-- 
          <button type="button" class="logh">Remove</button>

    // echo "<script>alert('You Can Only Rate Once.')</script>";
 -->
