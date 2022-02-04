<?php 

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;
require_once ('vendor/phpmailer/phpmailer/src/Exception.php');
require_once "vendor/autoload.php";
require_once "vendor/twilio/sdk/src/Twilio/autoload.php";
require_once ('vendor/phpmailer/phpmailer/src/PHPMailer.php');
require_once ('vendor/phpmailer/phpmailer/src/SMTP.php');

if(!isset($_SESSION['seller_name'])){
    header("Location: log-in.php");
}

if(isset($_POST['acceptOrdBtn'])){
$date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
$_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');

$costumer_ID = "SELECT * FROM order_list WHERE order_id = '".$_SESSION['order_id']."'";
$res = mysqli_query($connection2, $costumer_ID);
if (mysqli_num_rows($res)>0){
    while($row = mysqli_fetch_array($res)){
        // orderDetails
        $order_date =  $row['buy_date'];
        $costumer_Addr = $row['deliver_loc'];
        $prod_Quantity = $row['prod_quantity'];
        $prod_Size = $row['prod_size'];
        $total_Price = $row['prod_price'];


        // Product Details Query
        $sq = "SELECT * FROM product_desc where  product_id = '".$row['product_id']."'";
        $resu = mysqli_query($connection2, $sq);
        while($row2 = mysqli_fetch_array($resu)){
            // Product Details
        $prod_Name =  $row2['prod_name'];
        $prod_Img = $row2['prod_img'];
        $prod_Brand = $row2['brand_name'];
        $prod_Color = $row2['prod_color'];
        $prod_Gender = $row2['prod_gend'];
        $prod_Type = $row2['prod_type'];
        $prod_Desc = $row2['prod_desc'];
        }

        // Product Value Query
        $s = "SELECT * FROM product_value where  product_id = '".$row['product_id']."'";
        $res = mysqli_query($connection2, $s);
        while($row3 = mysqli_fetch_array($res)){
            // Product Value 
            if($prod_Size === 'Small'){
                $prod_Price = $row3['s_price'];
            }
            if($prod_Size === 'Medium'){
                $prod_Price = $row3['m_price'];
            }
            if($prod_Size === 'Large'){
                $prod_Price = $row3['l_price'];
            }
            if($prod_Size === 'X-Large'){
                $prod_Price = $row3['xl_price'];
            }

        }

        // Costumer Details Query
        $sql = "SELECT * FROM users where  id = '".$row['user_id']."'";
        $result = mysqli_query($connection2, $sql);
        while($row = mysqli_fetch_array($result)){
            // Costumer Details
        $costumer_Name =  $row['name'];
        $costumer_Number = '+63'.substr($row['contact_number'], 1, 10);
        $costumer_Email = $row['email'];
        }
        
    }
}
// SMS 
$twilioAcct = 'AC7be41a16cdf545671ac8356cdaf8bb00';
$twilioAuth = '364aeabc12aff118ee1ba7b5376f5e73';
$myNumber = '+18482807389';


$data = 'Good Day '. $costumer_Name .'
Seller accepted your order: 
Product: '. $_POST['prod_Name'] .'('.$_POST['colorInput'].', '. $_POST['prod_Type'] .', '. $_POST['prod_Size'] .', '. $_POST['prod_Quant'] .')
 ₱'. $_POST['prod_Amount'] .'.00';

// Email
$mail = new PHPMailer(true);
try {
    // Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = 'jas7iin@gmail.com'; // YOUR gmail email
    $mail->Password = 'jas7iin123'; // YOUR gmail password

    // Sender and recipient settings
    $mail->setFrom('jas7iin@gmail.com', 'BCMP Admin');
    $mail->addAddress($costumer_Email);
    $mail->addReplyTo('jas7iin@gmail.com', 'BCMP Admin'); // to set the reply to

    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = "Order confirmation";
    $mail->Body = '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="backgroundTable main-temp" style="background-color: #d5d5d5;">
            <tbody>
                <tr>
                    <td>
                        <table width="600" align="center" cellpadding="15" cellspacing="0" border="0" class="devicewidth" style="background-color: #ffffff;">
                            <tbody>
                                <!-- Start header Section -->
                                <tr>
                                    <td style="padding-top: 30px;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee; text-align: center;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-bottom: 10px;">
                                                        <a href=" "><img src="https://res.cloudinary.com/bcmp-uploader/image/upload/v1639076847/ico/asddas_1_yiie7u_fmgfcz.jpg" alt="BMCP" /></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        San Jose, Waling-waling St.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Balanga City, Bataan, 2100, Philippines
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Phone: +639167548216 | Email: jas7iin@gmail.com
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 25px;">
                                                        <strong>Order Number:</strong> '.$_SESSION['order_id'].' | <strong>Order Date:</strong> '.$order_date.'
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End header Section -->
                                
                                <!-- Start address Section -->
                                <tr>
                                    <td style="padding-top: 0;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 55%; font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        Delivery Adderss
                                                    </td>
                                                    <td style="width: 45%; font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        Billing Address
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        '.$costumer_Name.'
                                                    </td>
                                                    <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        '.$costumer_Name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        '.$costumer_Addr.'
                                                    </td>
                                                    <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        '.$costumer_Addr.'
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End address Section -->
                                
                                <!-- Start product Section -->
                                <tr>
                                    <td style="padding-top: 0;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee;">
                                            <tbody>
                                                <tr>
                                                    <td rowspan="4" style="padding-right: 10px; padding-bottom: 10px;">
                                                        <img style="height: 80px;" src="'.$prod_Img.'" alt="Product Image" />
                                                    </td>
                                                    <td colspan="2" style="font-size: 14px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        '.$prod_Name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                        Brand: '.$prod_Brand.'
                                                    </td>
                                                    <td style="width: 130px;"></td>
                                                </tr>
                                                <tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                        Description: '.$prod_Desc.'
                                                    </td>
                                                    <td style="width: 130px;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                        Gender: '.$prod_Gender.'
                                                    </td>
                                                    <td style="width: 130px;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                        Type: '.$prod_Type.'
                                                    </td>
                                                    <td style="width: 130px;"></td>
                                                </tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                        Quantity: '.$prod_Quantity.'
                                                    </td>
                                                    <td style="width: 130px;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575;">
                                                        Color: '.$prod_Color.' <span  style="height: 18px; width: 30px; background-color: '.$prod_Color.';"></span>
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right;">
                                                        ₱'.$prod_Price.'.00 Per Unit
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; padding-bottom: 10px;">
                                                        Size: '.$prod_Size.'
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right; padding-bottom: 10px;">
                                                        <b style="color: #666666;">₱'.$total_Price.'.00</b> Total
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End product Section -->
                                
                                <!-- Start calculation Section -->
                                <tr>
                                    <td style="padding-top: 0;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb; margin-top: -5px;">
                                            <tbody>
                                                <tr>
                                                    <td rowspan="5" style="width: 55%;"></td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Sub-Total:
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; width: 130px; text-align: right;">
                                                        ₱'.$total_Price.'.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; border-bottom: 1px solid #eeeeee;">
                                                        Shipping Fee:
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; border-bottom: 1px solid #eeeeee; text-align: right;">
                                                        ₱50.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px;">
                                                        Order Total
                                                    </td>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px; text-align: right;">
                                                        ₱'.($total_Price + 50).'.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666;">
                                                        Payment Term:
                                                    </td>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; text-align: right;">
                                                        100%
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End calculation Section -->
                                
                                <!-- Start payment method Section -->
                                <tr>
                                    <td style="padding: 0 10px;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" style="font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        Payment Method (Cash - on - Delivery)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="width: 100%; text-align: center; font-style: italic; font-size: 13px; font-weight: 600; color: #666666; padding: 15px 0; border-top: 1px solid #eeeeee;">
                                                        <b style="font-size: 14px;">Note:</b> This is not an official receipt of any product purchased. For Capstone Demo Purposes Only. Thank you!
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End payment method Section -->
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>';
    $mail->send();

    $client = new Twilio\Rest\Client($twilioAcct, $twilioAuth);

    $client->messages->create($costumer_Number, [
    	'from' => $myNumber,
    	'body' => $data
    ]);

        $xql = "UPDATE order_list SET accept_date ='".$_SESSION['timestamp']."', upd_date ='".$_SESSION['timestamp']."', status = 'Accepted' where  order_id = '".$_SESSION['order_id']."'";
        if ($connection2->query($xql) === TRUE) {
        echo "<script>alert('Order Accepted!');</script>";
        echo"<script>window.location.href='sellerprofile.php'; </script>";
            }else{
        echo "<script>alert('Order Not Accepted!');</script>";
        echo"<script>window.location.href='sellerprofile.php'; </script>";
                }
    
} catch (Exception $e) {
echo "<script>
if($mail->ErrorInfo){
    alert('Email not sent please check the email. Mailer Error: {$mail->ErrorInfo}');
}else{
    alert('Phone number not verified, please contact your administrator');
}
</script>";
}

}




if(isset($_POST['packedOrdBtn'])){
  $date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
  $_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');
  $xql = "UPDATE order_list SET packed_date ='".$_SESSION['timestamp']."', upd_date ='".$_SESSION['timestamp']."', status = 'Packed' where  order_id = '".$_SESSION['order_id']."'";
  if ($connection2->query($xql) === TRUE) {
      echo "<script>alert('Order Packed');</script>";
      echo"<script>window.location.href='sellerprofile.php' </script>";
  }else{
        echo "Error Confirmation: " . $connection2->error;
      }
}if(isset($_POST['shippedOrdBtn'])){
  $date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
  $_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
$costumer_ID = "SELECT user_id FROM order_list WHERE order_id = '".$_SESSION['order_id']."'";
$res = mysqli_query($connection2, $costumer_ID);
if (mysqli_num_rows($res)>0){
    while($row = mysqli_fetch_array($res)){
        $sql = "SELECT * FROM users where  id = '".$row['user_id']."'";
        $result = mysqli_query($connection2, $sql);
        while($row = mysqli_fetch_array($result)){
        $costumer_Name =  $row['name'];
        $costumer_Number = '+63'.substr($row['contact_number'], 1, 10);
        }
    }
}
// SMS 
$twilioAcct = 'AC7be41a16cdf545671ac8356cdaf8bb00';
$twilioAuth = '364aeabc12aff118ee1ba7b5376f5e73';
$myNumber = '+18482807389';

$data = 'Good Day '. $costumer_Name .'
You have a delivery today: 
Product: '. $_POST['prod_Name'] .'('.$_POST['colorInput'].', '. $_POST['prod_Type'] .', '. $_POST['prod_Size'] .', '. $_POST['prod_Quant'] .')
 ₱'. $_POST['prod_Amount'] .'.00, 
 Please prepare transaction fee with a total of ₱'. ($_POST['prod_Amount'] + 50) .'.00, Thank you. ';


try{
    $client = new Twilio\Rest\Client($twilioAcct, $twilioAuth);
    $client->messages->create($costumer_Number, [
    	'from' => $myNumber,
    	'body' => $data
    ]);

     $xql = "UPDATE order_list SET ship_date ='".$_SESSION['timestamp']."', upd_date ='".$_SESSION['timestamp']."', status = 'Shipped' where  order_id = '".$_SESSION['order_id']."'";
  if ($connection2->query($xql) === TRUE) {
      echo "<script>alert('Order Shipped');</script>";
      echo"<script>window.location.href='sellerprofile.php' </script>";
  }else{
        echo "Error Confirmation: " . $connection2->error;
      }

      
}catch(Exception $e){
      echo"<script>alert('Phone number not verified, please contact your administrator');</script>";
}
}
if(isset($_POST['completeOrdBtn'])){

    $date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
    $_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
    $xql = "UPDATE order_list SET recieve_date ='".$_SESSION['timestamp']."', upd_date ='".$_SESSION['timestamp']."', status = 'Recieved' where  order_id = '".$_SESSION['order_id']."'";
    if ($connection2->query($xql) === TRUE) {
        echo "<script>alert('Order Completed');</script>";
        echo"<script>window.location.href='sellerprofile.php' </script>";
    }else{
          echo "Error Completion: " . $connection2->error;
        }
}

if(isset($_POST['cancelOrdBtn'])){
    $date = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
    $_SESSION['timestamp'] = $date->format('Y-m-d h:i:s A');
$connection2 = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp");

$costumer_ID = "SELECT user_id FROM order_list WHERE order_id = '".$_SESSION['order_id']."'";
$res = mysqli_query($connection2, $costumer_ID);
if (mysqli_num_rows($res)>0){
    while($row = mysqli_fetch_array($res)){
        $sql = "SELECT * FROM users where  id = '".$row['user_id']."'";
        $result = mysqli_query($connection2, $sql);
        while($row = mysqli_fetch_array($result)){
        $costumer_Name =  $row['name'];
        $costumer_Number = '+63'.substr($row['contact_number'], 1, 10);
        }
    }
}
// echo"".$costumer_Number;
// SMS 
$twilioAcct = 'AC7be41a16cdf545671ac8356cdaf8bb00';
$twilioAuth = '364aeabc12aff118ee1ba7b5376f5e73';
$myNumber = '+18482807389';

// $toNumber = '+639167548216';

$data = 'Good Day '. $costumer_Name .',
    We apologize seller declined your order, thank you for your understanding.';


try{
    $client = new Twilio\Rest\Client($twilioAcct, $twilioAuth);
    $client->messages->create($costumer_Number, [
    	'from' => $myNumber,
    	'body' => $data
    ]);

    $xql = "UPDATE order_list SET cancel_date ='".$_SESSION['timestamp']."- Seller Declined - Product Unavailable', upd_date ='".$_SESSION['timestamp']."', status = 'Cancel' where  order_id = '".$_SESSION['order_id']."'";
    if ($connection2->query($xql) === TRUE) {
      if($_POST['prod_Size'] == 'Small'){$size = 'small';}
      if($_POST['prod_Size'] == 'Medium'){$size = 'medium';}
      if($_POST['prod_Size'] == 'Large'){$size = 'large';}
      if($_POST['prod_Size'] == 'X-Large'){$size = 'x_large';}
      $xql2 = "SELECT $size FROM product_value where  product_id = '".$_SESSION['product_id']."'";
      $res = mysqli_query($connection2, $xql2);
      $sizeQuant = mysqli_fetch_array($res)[$size];
      $totalQuant = $sizeQuant + $_POST['prod_Quant'];
      $xql2 = "UPDATE product_value SET  $size ='$totalQuant' where product_id = '".$_SESSION['product_id']."'";
        if ($connection2->query($xql2) === TRUE) {
          echo "<script>alert('Order Declined');</script>";
        echo"<script>window.location.href='sellerprofile.php' </script>";
    }else{
          echo "Error Cancelation: " . $connection2->error;
        }
    }

}catch(Exception $e){
      echo"<script>alert('Phone number not verified, please contact your administrator');</script>";
}


    
  }
?>