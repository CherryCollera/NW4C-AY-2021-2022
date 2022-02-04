<?php 
session_start();

if(!isset($_SESSION['seller_name'])){
    header("Location: log-in.php");
}

  $connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql1 = "SELECT * FROM product_desc where product_id ='".$_SESSION['product_id']."' ";
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

$sql3 = "SELECT * FROM order_list where order_id ='".$_SESSION['order_id']."' ";
$result3 = mysqli_query($connection2, $sql3);
if (mysqli_num_rows($result3)>0){
  while($row = mysqli_fetch_array($result3)){
    $_POST['user_id'] = $row['user_id'];
    $_POST['status'] = $row['status'];
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
$sql4 = "SELECT * FROM users where id ='".$_POST['user_id']."' ";
$result4 = mysqli_query($connection, $sql4);
if (mysqli_num_rows($result4)>0){
  while($row = mysqli_fetch_array($result4)){
    $_POST['cost_name'] = $row['name'];
    $_POST['cost_email'] = $row['email'];
    $_POST['cost_addr'] = $row['address'];
    $_POST['cost_cont'] = $row['contact_number'];
  }
}else{
  echo"<script>alert('No Users Fetched');</script>";
}
// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
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
    <link rel="stylesheet" type="text/css" href="product-details.css"/>
    <script type="text/javascript" src="ntc.js"></script>
</head>
<body>
<nav id="navigation" >
        <div onclick='showD()'  class='backBtn'><i class="fas fa-angle-left iconBack"></i> 
         Back</div>
        <img  title='Home'  class='navUL' onclick="window.location.href='userhome.php'" style='cursor:pointer' src='BMCP.png' class='userAdmtxt' alt='log'/>
        <ul id="log">
            <li><a class='regh' style="padding:4.5px 25px" href="sellerprofile.php"><?php echo"Welcome " . $_SESSION['seller_name'] ?><i class="fas fa-user-tie iconAdmin"></i></a></li>
            <li title='Log-out'><a class='regh'href="sellerlogout.php">Log-out</a></li>
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
      <?php  if($_SESSION['showUsers'] == 'Ship' || $_SESSION['showUsers'] == 'ToPacked' || $_SESSION['showUsers'] == 'ToShipped' || $_SESSION['showUsers'] == 'Complete'){ 
          echo "<p style='margin:5px 0;' class='prodmid'>Estimed Deliver Date: ".$_POST['est_date']."</p>";
      }?>
      <p style='margin:5px 0;' class='prodmid'>Size: <?php echo "". $_POST['prod_size']; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Quantity: <?php echo "". $_POST['prod_quantity']; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Price: <?php echo "₱ ". $_POST['prod_price'].".00"; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Transaction Type: Cash On Delivery</p>
      <p style='margin:5px 0;' class='prodmid'>Transaction Location: <?php echo "". $_POST['deliver_loc']; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Transaction Fee: ₱ 50.00</p>
      <p style='margin:5px 0;' class='prodmid'>Total Price: <?php echo "₱ ". ($_POST['prod_price'] + 50) . '.00'; ?></p>
        </div>
      </div>
      </div>
      <div class='prod_div' style='margin-bottom:25px;'>
    <div class='prod-warp' >
    </div>
      
      <div class='prod-warp' >
        <div class='ratings_div'>
            <p style='margin: -5px 0 15px 0;' class='titleRate'>Costumer Details</p>
      <p style='margin:5px 0;' class='prodmid'>Costumer Name: <?php echo "". $_POST['cost_name']; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Email Address: <?php echo "". $_POST['cost_email']; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Contact Number: <?php echo "". $_POST['cost_cont']; ?></p>
      <p style='margin:5px 0;' class='prodmid'>Address: <?php echo "". $_POST['cost_addr']; ?></p>
     </div>
      </div>
      </div>
      <?php
        if($_SESSION['showUsers'] == 'Order'){
          echo "<footer>
      <form action='prodSel.php' method='POST' class='footer-content'>
          <input name='prod_Name' type='hidden' value='$_POST[prod_name]'/>
          <input name='colorInput' type='hidden' value='a' id='colorInput'/>
          <input name='prod_Amount' type='hidden' value='$_POST[prod_price]'/>
          <input name='prod_Type' type='hidden' value='$_POST[prod_type]'/>
          <input name='prod_Size' type='hidden' value='$_POST[prod_size]'/>
          <input name='prod_Quant' type='hidden' value='$_POST[prod_quantity]'/>
           <button type='submit' name='acceptOrdBtn' class='logh'><i class='fas fa-check'></i>Accept</button>
           <button type='submit' name='cancelOrdBtn' class='regh'><i class='fas fa-times'></i>Decline</button>
      </form>
    </footer>";
      }else if($_SESSION['showUsers'] == 'ToPacked'){
        echo "<footer>
    <form action='prodSel.php' method='POST' class='footer-content'>
          <input name='prod_Size' type='hidden' value='$_POST[prod_size]'/>
          <input name='prod_Quant' type='hidden' value='$_POST[prod_quantity]'/>
         <button type='submit' name='packedOrdBtn' class='logh'><i class='fas fa-box'></i>Packed</button>
         <button type='submit' name='cancelOrdBtn' class='regh'><i class='fas fa-times'></i>Cancel</button>
    </form>
  </footer>";
    }else if($_SESSION['showUsers'] == 'ToShipped'){
      echo "<footer>
  <form action='prodSel.php' method='POST' class='footer-content'>
          <input name='prod_Name' type='hidden' value='$_POST[prod_name]'/>
          <input name='colorInput' type='hidden' value='a' id='colorInput'/>
          <input name='prod_Amount' type='hidden' value='$_POST[prod_price]'/>
          <input name='prod_Type' type='hidden' value='$_POST[prod_type]'/>
          <input name='prod_Size' type='hidden' value='$_POST[prod_size]'/>
          <input name='prod_Quant' type='hidden' value='$_POST[prod_quantity]'/>
    <button type='submit' name='shippedOrdBtn' class='logh'><i class='fas fa-shipping-fast'></i>Shipped</button>
  </form>
</footer>";
  }else if($_SESSION['showUsers'] == 'Ship'){
              echo "<footer>
          <form action='prodSel.php' method='POST' class='footer-content'>
               <button type='submit' name='completeOrdBtn' class='logh'><i class='fas fa-boxes'></i>Complete</button>
          </form>
        </footer>";
          }else if($_SESSION['showUsers'] == 'Complete'){
  $connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
           $sql = "SELECT * FROM product_rate where product_id = '".$_SESSION['product_id']."' && order_id = '".$_SESSION['order_id']."' && rater_id = '".$_POST['user_id']."'";
           $result = mysqli_query($connection, $sql);
           if (mysqli_num_rows($result)>0){
             while($row = mysqli_fetch_array($result)){
             echo'
             <div class="prod_div" style="margin-top:-450px;margin-left:-250px;">
             <div class="prod-warp" >
             <form  method="post"  enctype="multipart/form-data" action="" class="add_rating">
                     <p>'.$_POST['cost_name'].'′s Feedback</p>
                     <p class="prodmid">Rating for the transaction</p>
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
                     <p class="prodmid">Thoughts on the transaction </p>
                     <textarea name="rateDesc" class="rating-textarea" readonly>'.$row['rate_desc'].'</textarea>
                     <p class="prodmid">Some image </p>
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
           <div class="prod_div" style="margin-top:-375px;margin-left:-75px;">
           <div class="prod-warp" >
           <form  method="post"  enctype="multipart/form-data" action="" class="add_rating">
                   <p>No Feedback Yet</p>
               </form>
           </div>
             </div>';
           }
           }
          ?>
</body>

<script>
function showD(){
    window.location.href='sellerprofile.php';
}

window.addEventListener("load", startup, false);
function startup() {
  colorWell = document.querySelector("#color");
  colorWell2 = document.querySelector("#colorInput");
  color = '<?php echo"$_POST[prod_color]" ?>';
     var n_match  = ntc.name(color);
    var n_name       = n_match[1]; 
    colorWell.innerHTML = "Color: " + n_name;
    colorWell2.value = n_name;
}
</script>
</html>