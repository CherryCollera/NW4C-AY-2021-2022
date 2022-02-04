<?php

session_start();

require 'vendor/autoload.php';
require 'config-cloud.php';

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
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="userhome.css"/>
    <link rel="stylesheet" type="text/css" href="userprofile.css"/>
    <link rel="stylesheet" type="text/css" href="sellerprofile.css"/>
    <link rel="stylesheet" type="text/css" href="sellerReport.css"/>
    <link rel="stylesheet" type="text/css" href="addProduct.css"/>
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
        <h1>Report Seller</h1>
        <form method='post' action='' enctype="multipart/form-data" class='report_form'>
  <label for="prodAddName"><b>Name: </b><?php echo" ".$_SESSION['seller_name'] ?></label>

        
  <label for="prodAddGend"><b>Violation: </b>
  <select id='report_Type' name='report_Type' required defaultValue="Unisex" required> 
  <option value='' disabled selected>Please select Violation Type</option>
      <option value='Non-Delivery of Products'>Non-Delivery of Products</option>
      <option value='Child Exploitation'>Child Exploitation</option>
      <option value='COVID-19'>COVID-19</option>
      <option value='Harassment, Bullying, Defamation and Threats'>Harassment, Bullying, Defamation and Threats</option>
      <option value='Hateful Content'>Hateful Content</option>
      <option value='Illegal Activities'>Illegal Activities</option>
      <option value='Intellectual Property'>Intellectual Property</option>
      <option value='Malicious and Deceptive Practices'>Malicious and Deceptive Practices</option>
      <option value='Personal, Confidential and Protected Health Information'>Personal, Confidential and Protected Health Information</option>
      <option value='Restricted Items'>Restricted Items</option>
      <option value='Self Harm'>Self Harm</option>
      <option value='Spam'>Spam</option>
      <option value='Terrorist Organizations'>Terrorist Organizations</option>
</select></label>
    <label for="report_Desc"><b>Description: </b>
        <textarea name="report_Desc" class="rating-textarea" required></textarea>
    </label>
    <label for="report_file"><b>File: </b>
        <input name="report_File" type='file' required/>
    </label>
    <br/>
    <button type="submit" class="regh" name='report_Btn'>Submit</button>
</form>
    </div>
</body>

<?php
use Cloudinary\Api\Upload\UploadApi;


if(isset($_POST['report_Btn'])){

$date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
$_POST['report_Time'] = $date->format('Y-m-d h:i:s A');
$dateNow = substr($_POST['report_Time'], 0, 10);
// echo "".$dateNow;
$reportImg = $_FILES["report_File"]["name"];
$filepath = "images/".$_FILES["report_File"]["name"];
    $filename = $_FILES['report_File']['tmp_name'];
    // move_uploaded_file($filename, $filepath);
    $img = (new UploadApi())->upload($filename, [
        'public_id' => $reportImg,
        ]
        );
  $connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
    $sql = "INSERT INTO seller_report (reporter_id, seller_id, report_title, report_desc, report_time, report_file,isValid) VALUES ('".$_SESSION['user_id']."','".$_SESSION['seller_id']."','".$_POST['report_Type']."','".$_POST['report_Desc']."','".$dateNow."','".$img[url]."', 'false')";
    $sql2 = "SELECT * FROM seller_report where  seller_id = '".$_SESSION['seller_id']."' && reporter_id = '".$_SESSION['user_id']."' && report_time = '".$dateNow."'";
      $result2 = mysqli_query($connection2, $sql2);
      if (mysqli_num_rows($result2)>0){
            echo "<script>alert('Failed to Report Seller: You can only report him/her once a day.');
        window.location.href='product-store.php';
        </script>";
            }else{
    if($connection2->query($sql)) {
    echo "<script>alert('Seller Reported: Admins will validate your report and assess accordingly');
        window.location.href='product-store.php';
        </script>";
    }else {
    echo "<script>alert('Error Add to cart: $connection2->error');</script>";
    }
}
}


        
?>

<script>
function showD(){
    window.location.href='product-store.php';
}
</script>
</html>