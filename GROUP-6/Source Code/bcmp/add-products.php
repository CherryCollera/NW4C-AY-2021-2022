
<?php

session_start();

include 'config.php';
require 'vendor/autoload.php';
require 'config-cloud.php';

if(!isset($_SESSION['seller_name'])){
    header("Location: log-in.php");
}
$_POST['seller_name'] = $_SESSION['seller_name'];
$_POST['seller_id'] = $_SESSION['seller_id'];
$_POST['brand_name'] = $_SESSION['brand'];
  $connection = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp");
  $sql = "SELECT * FROM brand_names where brand_name ='".$_SESSION['brand']."' && seller_name ='".$_SESSION['seller_name']."' && seller_id ='".$_SESSION['seller_id']."' ";
  $result = mysqli_query($connection, $sql);
  if (mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result)){
      $_POST['brandId'] = $row['brand_id'];
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Clothing Management Portal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="stylesheet" type="text/css" href="addProduct.css"/>
    <script type="text/javascript" src="ntc.js"></script>
</head>
<style>
    </style>
<body>
<nav id="navigation" >
        <d class='userAdmtxt'><i onclick='showD()' class="fas fa-angle-left iconBack"></i> 
        Add Products</d>
        <ul id="log">
            <li><a class='regh' style="padding:4.5px 25px" href="#"><?php echo"Welcome " . $_SESSION['seller_name'] ?><i class="fas fa-user-tie iconAdmin"></i></a></li>
            <li><a class='logh'href="sellerlogout.php">Logout</a></li>
        </ul>
    </nav>
 <div class="AddProdDiv">
   
<div class="AddProdForm">
  <form method="post"  enctype="multipart/form-data" action=''>
    <h2>Description
     <div>
        <button type='submit' onsubmit='onSubmitProdData()' class='btn' name='submitProd' ><i class="fas fa-save"></i> Save</button>
        <button type='button' onclick='showD()' class='btn nega' name='cancelProd' ><i class="fas fa-ban"></i> Cancel</button>
     </div>
  </h2>
  <div class='inputTextAddProd' style='grid-column: 1/7; '>
  <label for="prodAddName"><b>Name:</b></label>
    <input type='text' name='prodAddName' required />
  </div>
  <div class='inputTextAddProd' style='grid-column: 7/11; '>
  <label for="prodAddColorHex"><b>Color:</b></label>
    <input style="width:20%; margin: auto 5px; cursor:pointer; " type='color' required  id="colorWell" name='prodAddColorHex' />
    <input id='demo' readonly type='text' style='text-align: center;' />
  </div>

  <div class='inputTextAddProd' style='grid-column: 11/14; '>
  <label for="prodAddGend"><b>Gender:</b></label>
  <select id='prodAddGend' name='prodAddGend' required defaultValue="Unisex">
  <option value='' disabled selected hidden>Gender</option>
      <option value='Male'>Male</option>
      <option value='Female'>Female</option>
      <option value='Unisex'>Unisex</option>
</select>
  </div>

  <div class='inputTextAddProd' style='grid-column: 1/14; '>
  <label for="prodAddDesc"><b>Description:</b></label>
    <input type='text' name='prodAddDesc' required />
  </div>

  <div class='inputTextAddProd selectAdd' >
  <label for="prodAddType"><b>Type:</b></label>
    <select name='prodAddType' required>
         <option value='' disabled selected hidden>Please Select Item Type</option>
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
    <input type="file" name="prodAddImage" id='imgInp' required/>
    <div class='prodAddImg'>
      <div class='AddImgContainer'> 
    <img id='blah' alt='logo' src="defaul_img.png"  />
    </div>
    </div>
    </div>
  <div class='quaHEader'  style='grid-column: 2/2;'>Sizes</div>
  <div class='quaHEader'  style='grid-column: 3/5;'>Quantity</div>
  <div class='quaHEader'  style='grid-column: 5/7;'>Price(₱)</div>
  <div  class='inputTextAddProd'style='font-size:18px;  grid-column: 2/2; width:fit-content; '>Small</div>
  <div class='inputTextAddProd'  style='grid-column: 3/5;'>
    <input type='number' name='sQuan' required />
  </div>
  <div class='inputTextAddProd' style='grid-column: 5/7'>
    <input type='number' name='sPrice' required />
  </div>
  <div  class='inputTextAddProd'style='font-size:18px;  grid-column: 2/2; width:fit-content; '>Medium</div>
  <div class='inputTextAddProd'  style='grid-column: 3/5;'>
    <input type='number' name='mQuan' required/>
  </div>
  <div class='inputTextAddProd' style='grid-column:  5/7'>
    <input type='number' name='mPrice' required />
  </div>
  <div  class='inputTextAddProd'style='font-size:18px; grid-column: 2/2; width:fit-content; '>Large</div>
  <div class='inputTextAddProd'  style='grid-column: 3/5;'>
    <input type='number' name='lQuan' required/>
  </div>
  <div class='inputTextAddProd' style='grid-column:  5/7'>
    <input type='number' name='lPrice' required/>
  </div>
  <div  class='inputTextAddProd'style='font-size:18px; grid-column: 2/2; width:fit-content; width: 150px;'>Extra-Large</div>
  <div class='inputTextAddProd'  style='grid-column: 3/5;'>
    <input type='number' name='xlQuan' required/>
  </div>
  <div class='inputTextAddProd' style='grid-column:  5/7'>
    <input type='number' name='xlPrice'required />
  </div>
</form>
</div>
</div>
<?php 
use Cloudinary\Api\Upload\UploadApi;

if (isset($_POST['submitProd'])) {
  $prodName = $_POST['prodAddName'];
  $prodDesc = $_POST['prodAddDesc'];
  $prodType = $_POST['prodAddType'];
  $prodGend = $_POST['prodAddGend'];
  $prodColorHex = $_POST['prodAddColorHex'];
  $prodImg = $_FILES["prodAddImage"]["name"];
  $sQuan = $_POST['sQuan'];
  $sPrice = $_POST['sPrice'];
  $mQuan = $_POST['mQuan'];
  $mPrice = $_POST['mPrice'];
  $lQuan = $_POST['lQuan'];
  $lPrice = $_POST['lPrice'];
  $xlQuan = $_POST['xlQuan'];
  $xlPrice = $_POST['xlPrice'];

  $connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  $sql2 = "SELECT * FROM product_desc where  prod_name = '$prodName' && brand_name = '".$_POST['brand_name']."' && brand_id = '".$_POST['brandId']."'";
  $result2 = mysqli_query($connection2, $sql2);
  $ExistCount = 0;
  if (mysqli_num_rows($result2)>0){
    echo "<script>alert('Failed to Add: Product do exist.');</script>";
      }else{
        $filepath = "images/".$_FILES["prodAddImage"]["name"];
        $filename = $_FILES['prodAddImage']['tmp_name'];
         $img = (new UploadApi())->upload($filename, [
          'public_id' => $prodName,
          ]
          );
          if($connection2->query("insert into product_desc (brand_id, brand_name, prod_name, prod_img, prod_color, prod_gend, prod_type, prod_desc) value ('$_POST[brandId]','$_POST[brand_name]','$prodName','$img[url]','$prodColorHex','$prodGend' ,'$prodType' ,'$prodDesc')")) {
              if($connection2->query("insert into product_value (brand_id, brand_name, prod_name, small, medium, large, x_large, s_price, m_price, l_price, xl_price) value ('$_POST[brandId]','$_POST[brand_name]','$prodName', '$sQuan', '$mQuan', '$lQuan', '$xlQuan', '$sPrice', '$mPrice', '$lPrice', '$xlPrice')")){
                echo "<script>alert('Success: Product added'); window.location.href='sellerpage.php';</script>";
              }else{
                echo "<script>alert('Error: No Product Value'); window.location.href='sellerpage.php';</script>";
              }
          }else {
              echo "<script>alert('Error: No Product Details'); window.location.href='sellerpage.php';</script>";
          }
        }
}


    
if (isset($_POST['cancelProd'])) {
  echo"<script>window.location.href='sellerpage.php';</script>";
}

?>

</body>
<script>
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
var defaultColor = "#000000";
var colorTExt;

window.addEventListener("load", startup, false);

function startup() {
  colorWell = document.querySelector("#colorWell");
  colorTExt = document.querySelector("#demo");
  defaultColor = colorWell.value;
  var color = ntc.name(defaultColor);
  colorTExt.value = color[1];
  colorWell.addEventListener("change", updateFirst, false);
  colorWell.select();
}

function updateFirst(event) {
    document.getElementById("demo").value =  hex2a(event.target.value);
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