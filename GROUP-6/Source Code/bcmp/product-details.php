<?php

session_start();
if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}
unset($_SESSION["timestamp"]);

// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

$_POST['prod_id'] = $_SESSION['product_id'];
// Product Details
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
    <link rel="stylesheet" type="text/css" href="userhome.css"/>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="product-details.css"/>
    <script type="text/javascript" src="ntc.js"></script>
</head>
<style>
    </style>
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
          <p class='prodHead'>Size</p>
          <p class='prodHead'>Quantity</p>
          <p class='prodHead'>Price</p>
          <p class='prodHead'>Small</p>
          <p class='prodTail'><?php echo "". $_POST['small']; ?></p>
          <p class='prodTail'><?php echo "₱ ". $_POST['s_price'].".00"; ?></p>
          <p class='prodHead'>Medium</p>
          <p class='prodTail'><?php echo "". $_POST['medium']; ?></p>
          <p class='prodTail'><?php echo "₱ ". $_POST['m_price'].".00"; ?></p>
          <p class='prodHead'>Large</p>
          <p class='prodTail'><?php echo "". $_POST['large']; ?></p>
          <p class='prodTail'><?php echo "₱ ". $_POST['l_price'].".00"; ?></p>
          <p class='prodHead'>X-Large</p>
          <p class='prodTail'><?php echo "". $_POST['x_large']; ?></p>
          <p class='prodTail'><?php echo "₱ ". $_POST['xl_price'].".00"; ?></p>
        </div>
      </div>
      <div class='prod-warp' >
        <div class='ratings_div'>
            <p class='titleRate'>Reviews</p>
<?php 
$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql = "SELECT * FROM product_rate where product_id = '".$_SESSION['product_id']."'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result)>0){
  while($row = mysqli_fetch_array($result)){
          echo"<div class='rate_content'>";
            
          if($row['rater_id'] == $_SESSION['user_id']){
            echo" <p class='prodmid'> You</p>";
          }else{
         echo" <p class='prodmid'>".$row['rater_name']."</p>";
        }
            echo"<label class='rating-label fixsa'>
              <input
                class='rating'
                max='5'
                style='--value:".$row['rate_value']."'
                step='1'
                type='range'
                value=''/>
            <span>".$row['rate_value']."</span>

            </label>
            <p class='prodmid'>".$row['rate_desc']."</p>";

            if($row['rateImg'] != ''){
              echo'<img id="blah" alt="logo" src="'.$row['rateImg'].'" src="defaul_img.png" class="rateDi" />';
            }


          echo"</div>";
  }
}else{
  echo"<div class='rate_content'>
    <p style='text-align:center;' class='prodmid'>No Reviews yet</p>
  </div>";
}
?>
        </div>
      </div>

      <div id='buyME' class='buy_cloak' >
        <div class='hid' onclick='hidME()'></div>
        <form method='POST' action='FormBuyAct.php' class='buyCompDiv'>
          <img src="<?php echo "". $_POST['prod_img']; ?>"  alt="as" class="prodImage"/>
          <div class='prodInf'>
            <p class='ProdName'><?php echo "". $_POST['prod_name']; ?></p>
            <p class='BrandName'><?php echo "". $_POST['brand_name']; ?></p>
            <input type="hidden" name="seller_id" class='BrandName' value="<?php echo "". $_POST['seller_id']; ?>" />
            <div class='buySelect'>
            <select id='prodSize' onchange='selectSize()' name="prod_Size" required>
                <option value='' disabled selected hidden>Please Select Item Size</option>
                <?php if($_POST['small']>=1){ echo'<option value="Small">Small</option>';} ?>
                <?php if($_POST['medium']>=1){ echo'<option value="Medium">Medium</option>';} ?>
                <?php if($_POST['large']>=1){ echo'<option value="Large">Large</option>';} ?>
                <?php if($_POST['x_large']>=1){ echo'<option value="X-Large">X-Large</option>';} ?>
                </select>
               <input id='prodQuan' onkeydown="return false" placeholder="Quantity" type='number' name='prod_Quant' min='1' max='12' required class='ProdQuan' onchange='selectSize()' />
               <input id='prodPrice' type='text' placeholder='Price' class='ProdQuan'  name='prod_Price' readonly/>
          </div>
          <div class='buySelect'>
            <select style='margin:5px;' id='prodLoc' onchange='selectLoc()' name="prod_LocSel" required>
                <option value='' disabled selected hidden>Please select Delivery Location</option>
                <option value='Exist' >Existing Address</option>
                <option value='Custom' >Custom Address</option>
              </select>
            <p  class='transfee'>Transaction Type:  Cash on Delivery </p>
          </div>
          <div class='buySelect'>
              <input style='width:100%; margin:5px;' id='prodLocCustom' type='hidden' placeholder='Location' class='ProdQuan'  name='prod_LocCus' />
              <input style='width:100%; margin:5px;' id='prodLocExist' type='hidden' value='<?php echo "". $_SESSION['user_address']; ?>' readonly class='ProdQuan'  name='prod_LocExi' />
            <p class='transfee'>Transaction fee:    ₱  50.00</p>
          </div>
          <div class='buySelect'>
            <p id='totalFee' class='transfee'>Total fee:  ₱  0.00 </p>
          </div>
          <div style="margin-left:67%; width:32.5%;" class='hr'></div>
          <div class='buySelect'>
            <button name='buyEnd' type='submit' class='logh'><i class="fas fa-cart-plus"></i>Buy</button>
          </div>
      </form>
      </div>

    </div>
    <footer>
      <?php 
      echo"
        <form action='product-detailsAct.php' method='POST' class='footer-content'>
        <button type='submit' name='viewStore' class='logh'><i class='fas fa-store'></i>View Store</button>
        <button type='button' onclick='showMe()' name='buyProd' class='logh'><i class='fas fa-cart-arrow-down'></i>Buy</button>
        ";
        
$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
        $sql3 = "SELECT * FROM product_cart WHERE product_id = ".$_SESSION['product_id']." && user_id = ".$_SESSION['user_id']."";
        $result3 = mysqli_query($connection, $sql3);
        if (mysqli_num_rows($result3)>0){
        echo'<button type="submit" class="regh" value="'.$_SESSION["product_id"].'"  name="UnCartBtn"><i class="fas fa-shopping-cart"></i>Added to Cart</button>';
        }else{
        echo'<button type="submit" class="logh" value="'.$_SESSION["product_id"].'" name="BuyBtn"><i class="fas fa-cart-plus"></i> Add to Cart</button>';
        }
        ?>
    </footer>
</body>
<script>
function selectSize(){
  size = document.querySelector("#prodSize");
  quan = document.querySelector("#prodQuan");
  price = document.querySelector("#prodPrice");
  fee = document.querySelector("#totalFee");
  var siez = size.value; 
  if(siez == 'Small'){
    quan.max = Number(<?php echo"$_POST[small]" ?>);
    var pres =  Number(<?php echo"$_POST[s_price]" ?>) * Number(quan.value);
    price.value= pres;
    var tots = pres + 50
    var total = tots.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    fee.innerHTML= "Total fee:  ₱  "+ total +".00 ";
  }else if(siez == 'Medium'){
    quan.max = Number(<?php echo"$_POST[medium]" ?>);
    var pres =  Number(<?php echo"$_POST[m_price]" ?>) * Number(quan.value);
    price.value= pres;
    var tots = pres + 50
    var total = tots.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    fee.innerHTML= "Total fee:  ₱  "+ total +".00 ";
  }else if(siez == 'Large'){
    quan.max = Number(<?php echo"$_POST[large]" ?>);
    var pres =  Number(<?php echo"$_POST[l_price]" ?>) * Number(quan.value);
    price.value= pres;
    var tots = pres + 50
    var total = tots.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    fee.innerHTML= "Total fee:  ₱  "+ total +".00 ";
  }else if(siez == 'X-Large'){
    quan.max = Number(<?php echo"$_POST[x_large]" ?>) ;;
    var pres =  Number(<?php echo"$_POST[xl_price]" ?>) * Number(quan.value);
    price.value= pres;
    var tots = pres + 50
    var total = tots.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    fee.innerHTML= "Total fee:  ₱  "+ total +".00 ";
  }
}
function selectLoc(){
  quan = document.querySelector("#prodLoc");
  if(quan.value == 'Exist'){
  document.getElementById("prodLocCustom").type = 'hidden'
    document.getElementById("prodLocCustom").required = 'false'
  document.getElementById("prodLocExist").type = 'text'
  }else if(quan.value == 'Custom'){
    document.getElementById("prodLocExist").type = 'hidden'
    document.getElementById("prodLocCustom").type = 'text'
    document.getElementById("prodLocCustom").required = 'true'
  }
}

function confirma(){
  if (confirm('Are you sure you want to save this thing into the database?')) {
  // Save it!
  console.log('Thing was saved to the database.');
} else {
  // Do nothing!
  console.log('Thing was not saved to the database.');
}
}

function showMe(){
  document.getElementById("buyME").className = 'buy_cloak clok'
}
function hidME(){
  document.getElementById("buyME").className = 'buy_cloak'
}
function showD(){
    window.location.href='userhome.php';
}

window.addEventListener("load", startup, false);
var GenderSelect;
function startup() {
  colorWell = document.querySelector("#color");
  color = '<?php echo"$_POST[prod_color]" ?>';
     var n_match  = ntc.name(color);
    var n_name       = n_match[1]; 
    colorWell.innerHTML = "Color: " + n_name;
}
</script>
</html>