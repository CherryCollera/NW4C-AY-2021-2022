<?php
session_start();
    use Cloudinary\Api\Upload\UploadApi;

require 'vendor/autoload.php';
require 'config-cloud.php';

if(!isset($_SESSION['seller_name'])){
    header("Location: log-in.php");
}

$_POST['seller_name'] = $_SESSION['seller_name'];
$_POST['seller_id'] = $_SESSION['seller_id'];
$_POST['brand_name'] = $_SESSION['brand'];
//BrandId
$connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql = "SELECT * FROM brand_names where brand_name ='".$_SESSION['brand']."' && seller_name ='".$_SESSION['seller_name']."' && seller_id ='".$_SESSION['seller_id']."' ";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result)>0){
  while($row = mysqli_fetch_array($result)){
    $_POST['brand_id'] = $row['brand_id'];
  }
}
$_POST['prod_id'] = $_SESSION['prodID'];
// Product Details
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
$sql1 = "SELECT * FROM product_desc where brand_name ='".$_POST['brand_name']."' && brand_id ='".$_POST['brand_id']."' && product_id ='".$_POST['prod_id']."' ";
$result1 = mysqli_query($connection2, $sql1);
if (mysqli_num_rows($result1)>0){
  while($row = mysqli_fetch_array($result1)){
    $_POST['prod_name'] = $row['prod_name'];
    $_POST['prod_img'] = $row['prod_img'];
    $_POST['prod_color'] = $row['prod_color'];
    $_POST['prod_gend'] = $row['prod_gend'];
    $_POST['prod_type'] = $row['prod_type'];
    $_POST['prod_desc'] = $row['prod_desc'];
  }
}else{
  echo"<script>alert('No Product Fetched');</script>";
}
$sql2 = "SELECT * FROM product_value where brand_name ='".$_POST['brand_name']."' && brand_id ='".$_POST['brand_id']."' && product_id ='".$_POST['prod_id']."' ";
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

if(isset($_POST['submitProd'])){
    
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  $prodName = $_POST['prodAddName'];
  $prodDesc = $_POST['prodAddDesc'];
  $prodType = $_POST['prodAddType'];
  $prodGend = $_POST['prodAddGend'];
  $prodColorHex = $_POST['prodAddColorHex'];
  $prodImg = $_FILES["prodAddImage"]["name"];
  if($prodImg == ""){
  }
  $sQuan = $_POST['sQuan'];
  $sPrice = $_POST['sPrice'];
  $mQuan = $_POST['mQuan'];
  $mPrice = $_POST['mPrice'];
  $lQuan = $_POST['lQuan'];
  $lPrice = $_POST['lPrice'];
  $xlQuan = $_POST['xlQuan'];
  $xlPrice = $_POST['xlPrice'];

  $filepath = "images/".$_FILES["prodAddImage"]["name"];
  $filename = $_FILES['prodAddImage']['tmp_name'];
  // move_uploaded_file($filename, $filepath);
if($filename){
            $img = (new UploadApi())->upload($filename, [
          'public_id' => $prodImg,
          ]
          );
            $prodImg = $img ['url'];
        }else{
            $prodImg = $_POST['prod_img'];
        }
  $sql = "UPDATE product_desc SET prod_name ='$prodName', prod_img='$prodImg', prod_color='$prodColorHex', prod_gend ='$prodGend',prod_type ='$prodType', prod_desc ='$prodDesc' WHERE brand_name ='".$_POST['brand_name']."' && brand_id ='".$_POST['brand_id']."' && product_id ='".$_POST['prod_id']."'";
  $sql2 = "UPDATE product_value SET small ='$sQuan', medium ='$mQuan', large ='$lQuan', x_large ='$xlQuan', s_price ='$sPrice',m_price ='$mPrice', l_price ='$lPrice', xl_price='$xlPrice' WHERE brand_name ='".$_POST['brand_name']."' && brand_id ='".$_POST['brand_id']."' && product_id ='".$_POST['prod_id']."'";
  if ($connection2->query($sql) === TRUE) {
    if ($connection2->query($sql2) === TRUE) {
        echo "<script>alert('Product updated successfully'); window.location.href='productdetails.php';</script>";
    }else{
      echo "Error updating record: " . $connection2->error;
    }
  } else {
    echo "Error updating record: " . $connection2->error;
  }
}

if(isset($_POST['delProd'])){
    // DELETE FROM `product_desc` WHERE 0
    $sql = "DELETE FROM product_desc WHERE brand_name ='".$_POST['brand_name']."' && brand_id ='".$_POST['brand_id']."' && product_id ='".$_POST['prod_id']."'";
    $sql2 = "DELETE FROM product_value WHERE brand_name ='".$_POST['brand_name']."' && brand_id ='".$_POST['brand_id']."' && product_id ='".$_POST['prod_id']."'";
    $sql3 = "DELETE FROM product_cart WHERE product_id ='".$_POST['prod_id']."'";
    $sql4 = "DELETE FROM order_list WHERE product_id ='".$_POST['prod_id']."'";
    $sql5 = "DELETE FROM product_rate WHERE product_id ='".$_POST['prod_id']."'";
    if ($connection2->query($sql) === TRUE ) {
        if ($connection2->query($sql2) === TRUE ) {
            if ($connection2->query($sql3) === TRUE ) {
                if ($connection2->query($sql4) === TRUE ) {
                        if ($connection2->query($sql5) === TRUE ) {

            echo "<script>alert('Product deleted successfully'); window.location.href='sellerpage.php';</script>";

    } else { echo "Error deleting record: " . $connection2->error; }
    } else { echo "Error deleting record: " . $connection2->error; }    
    } else { echo "Error deleting record: " . $connection2->error; }
    } else { echo "Error deleting record: " . $connection2->error; }            
    } else { echo "Error deleting record: " . $connection2->error; }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css"/>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="addProduct.css"/>
    <script type="text/javascript" src="ntc.js"></script>
</head>
<style>
  
  </style>
<body>
<nav id="navigation" >
        <p class='userAdmtxt'><i onclick='showD()' class="fas fa-angle-left iconBack"></i>Products Details</p>
        <ul id="log">
            <li><a class='regh' style="padding:4.5px 25px" href="sellerProfileAct.php"><?php echo"Welcome " . $_SESSION['seller_name'] ?><i class="fas fa-user-tie iconAdmin"></i></a></li>
            <li><a class='logh'href="sellerlogout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="AddProdDiv">
   
   <div class="AddProdForm">
     <form method="post"  enctype="multipart/form-data" action=''>
       <h2>Description
        <div>
           <button type='submit' onsubmit='onSubmitProdData()' class='btn' name='submitProd' formnovalidate ><i class="fas fa-save"></i> Save</button>
           <button type='button' class='btn nega' onclick='showR()' name='delYes'><i class="fas fa-trash"></i> Delete</button>
        </div>
     </h2>
     <div class='inputTextAddProd' style='grid-column: 1/7; '>
     <label for="prodAddName"><b>Name:</b></label>
       <input type='text' value='<?php echo"" . $_POST['prod_name']; ?>' name='prodAddName' required />
     </div>
     <div class='inputTextAddProd' style='grid-column: 7/11; '>
     <label for="prodAddColorHex"><b>Color:</b></label>
       <input style="width:20%; margin: auto 5px; cursor:pointer; " type='color'  value=<?php echo" " . $_POST['prod_color']; ?> required  id="colorWell1" name='prodAddColorHex' />
       <input id='demo1' readonly type='text' style='text-align: center;' />
     </div>
   
     <div class='inputTextAddProd' style='grid-column: 11/14; '>
     <label for="prodAddGend"><b>Gender:</b></label>
     <select id='prodAddGend' name='prodAddGend' required>
        <option value='' disabled>Gender</option>
         <option value="Male">Male</option>
         <option value="Female">Female</option>
         <option value="Unisex">Unisex</option>
   </select>
     </div>
   
     <div class='inputTextAddProd' style='grid-column: 1/14; '>
     <label for="prodAddDesc"><b>Description:</b></label>
       <input type='text' value='<?php echo" " . $_POST['prod_desc']; ?>' name='prodAddDesc' required />
     </div>
     <div class='inputTextAddProd' style='grid-column: 1/4; '>
     <label for="prodAddBrand"><b>Brand:</b></label>
       <input type='text' name='prodAddBrand' required value='<?php echo" " . $_POST['brand_name']; ?>' readonly/>
     </div>
     <div class='inputTextAddProd selectAdd' style='grid-column:4/9'>
     <label for="prodAddType"><b>Type:</b></label>
       <select name='prodAddType' id='prodAddType' required>
         <option value='' disabled hidden>Please Select Item Type</option>
         <option value='Bottoms'>Bottoms</option>
         <option value='Caps'>Caps</option>
         <option value='Hoodie'>Hoodie</option>
         <option value='Jacket'>Jacket</option>
         <option value='Others'>Others</option>
         <option value='Shoes'>Shoes</option>
         <option value='Shorts'>Shorts</option>
         <option value='Tops'>Tops</option>
       </select>
     </div>
   
     <div class='inputTextAddProd' style='grid-column: 9/14; align-items:flex-start; '>
     <label for="prodAddImage">Image: </label>
       <input type="file" name="prodAddImage" id='imgInp' value='<?php echo" " . $_POST['prod_img']; ?>' required/>
       <div class='prodAddImg'>
         <div class='AddImgContainer'> 
       <img id='blah' alt='logo' src="<?php echo "". $_POST['prod_img']; ?>"  />
       </div>
       </div>
       </div>
     <div class='quaHEader'  style='grid-column: 2/2;'>Sizes</div>
     <div class='quaHEader'  style='grid-column: 3/5;'>Quantity</div>
     <div class='quaHEader'  style='grid-column: 5/7;'>Price(₱)</div>
     <div  class='inputTextAddProd'style='font-size:18px;  grid-column: 2/2; width:fit-content; '>Small</div>
     <div class='inputTextAddProd'  style='grid-column: 3/5;'>
       <input type='number' value='<?php echo"" . $_POST['small']; ?>' name='sQuan' required />
     </div>
     <div class='inputTextAddProd' style='grid-column: 5/7'>
       <input type='number' value='<?php echo"" . $_POST['s_price']; ?>' name='sPrice' required />
     </div>
     <div  class='inputTextAddProd'style='font-size:18px;  grid-column: 2/2; width:fit-content; '>Medium</div>
     <div class='inputTextAddProd'  style='grid-column: 3/5;'>
       <input type='number' value='<?php echo"" . $_POST['medium']; ?>' name='mQuan' required/>
     </div>
     <div class='inputTextAddProd' style='grid-column:  5/7'>
       <input type='number' value='<?php echo"" . $_POST['m_price']; ?>' name='mPrice' required />
     </div>
     <div  class='inputTextAddProd'style='font-size:18px; grid-column: 2/2; width:fit-content; '>Large</div>
     <div class='inputTextAddProd'  style='grid-column: 3/5;'>
       <input type='number' value='<?php echo"" . $_POST['large']; ?>' name='lQuan' required/>
     </div>
     <div class='inputTextAddProd' style='grid-column:  5/7'>
       <input type='number' value='<?php echo"" . $_POST['l_price']; ?>' name='lPrice' required/>
     </div>
     <div  class='inputTextAddProd'style='font-size:18px; grid-column: 2/2; width:fit-content; width: 150px;'>Extra-Large</div>
     <div class='inputTextAddProd'  style='grid-column: 3/5;'>
       <input type='number' value='<?php echo"" . $_POST['x_large']; ?>' name='xlQuan' required/>
     </div>
     <div class='inputTextAddProd' style='grid-column:  5/7'>
       <input type='number' value='<?php echo"" . $_POST['xl_price']; ?>' name='xlPrice'required />
     </div>
   </form>
<div class='blocker' id='block_er'>
<div class="addBRandDvi" style="height:fit-content;" >
        <h4 class="modal-title" style="text-align: center; padding:5px; font-size: 1.2rem; font-weight: 600;">Are you sure you want to delete this product?</h4>
      <form action="" method="POST" class="btn_Confirm" '>
           <button type='submit' class='btn nega1' name='delProd' value="ignore" formnovalidate  >Yes</button>
           <button type='button' onclick='showA()' class='btn' >No</button>
    </form>
  </div>
  </div>

   </div>
   </div>
</body>
<script>
  

function showR(){
  document.getElementById("block_er").className = 'blocker in';
}
function showA(){
  document.getElementById("block_er").className = 'blocker';
}
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
function showD(){
  window.location.href='sellerpage.php'
}
var colorWell;
var defaultColor;
var colorTExt;

window.addEventListener("load", startup, false);

function startup() {
  colorWell = document.querySelector("#colorWell1");
  colorTExt = document.querySelector("#demo1");
  GenderSelect = document.querySelector("#prodAddGend");
  TypeSelect = document.querySelector("#prodAddType");
  defaultColor = colorWell.value;
  GenderSelect.value = '<?php echo"$_POST[prod_gend]" ?>';
  TypeSelect.value = '<?php echo"$_POST[prod_type]" ?>';
  var color = ntc.name(defaultColor);
  colorTExt.value = color[1];
  colorWell.addEventListener("change", updateFirst, false);
  colorWell.select();
}

function updateFirst(event) {
    document.getElementById("demo1").value =  hex2a(event.target.value);
}
function hex2a(hex) 
{
    var n_match  = ntc.name(hex);
    var n_rgb        = n_match[0]; // This is the RGB value of the closest matching color
    var n_name       = n_match[1]; // This is the text string for the name of the match
    var n_exactmatch = n_match[2]; // True if exact color match, False if close-match
return n_name;
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


