<?php

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION['name'])){
    header("Location: log-in.php");
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $address = $_POST['address'];
    $cnumber = $_POST['cnumber'];


    if ($password == $cpassword){
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result -> num_rows > 0){
            $sql = "INSERT INTO users (name, email, password, address, contact_number)
                VALUES ('$name', '$email', '$password', '$address', '$cnumber')";
            $result = mysqli_query($conn, $sql);

            $costumers = "SELECT * FROM users";
            $res = mysqli_query($conn, $costumers) or die("Error in Selecting " . mysqli_error($conn));
            $emparray = array();
                while($row =mysqli_fetch_assoc($res))
            {
                $emparray[] = $row;
            }
            $json = json_encode(array('data' => $emparray));
            file_put_contents("data.json", $json);


            if ($result){
                echo "<script>alert('Registration Successful.')</script>";
                $name = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
                $address = "";
                $cnumber = "";
                mysqli_close($conn);
            } else {
                echo "<script>alert('Something Went Wrong.')</script>";
                mysqli_close($conn);
            }
        } else {
            echo "<script>alert('Email Already Used.')</script>";
                mysqli_close($conn);
        }  
    } else {
        echo "<script>alert('Password Not Matched.')</script>";
                mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
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
    <div id="wrapper">
        <div id="banner">
   </div>     
    
   <nav id="navigation" >
        <d class='userAdmtxt'><form action="productSearch.php" method="POST" class='navUSerHome'><input name='userSearch' placeholder='Search here...' type='text' /><button name='btnuserSearch' type='submit' ><i class="fas fa-search"></i></button></form></d>
        <img  title='Home'  class='navUL' onclick="window.location.href='main.php'" style='cursor:pointer' src='BMCP.png' class='userAdmtxt' alt='log'/>
        <ul id="log">
            <li><a class='regh' href="register.php">Register</a></li>
            <li><a class='logh' href="log-in.php">Log-in</a></li>
        </ul>
    </nav>

        <div class="container">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800; color: white;">Register</p>
                <div class="input-group">
                    <input class="inputs"  type="text" placeholder="Name" name="name" value="<?php echo $name;?>" required>
                </div>
                <div class="input-group">
                    <input class="inputs" type="email" placeholder="Email" name="email" value="<?php echo $email;?>" required>
                </div>
                <div class="input-group">
                    <input class="inputs"  type="password" placeholder="Password" name="password" value="<?php echo $_POST['password'];?>" required>
                </div>
                <div class="input-group">
                    <input class="inputs"  type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword'];?>" required>
                </div>
                <div class="input-group">
                    <input class="inputs"  type="text" placeholder="Address" name="address" value="<?php echo $address;?>" required>
                </div>
                <div class="input-group">
                    <input class="inputs"  type="tel" placeholder="Contact Number" pattern="[0-9]{11}" name="cnumber" value="<?php echo $cnumber;?>" required>
                </div>
                <div class="input-group">
                    <button name="submit" class="btn">Register</button>
                </div>
                <p class="login-register-text">Already have an account? <a href="log-in.php">Login Here</a>.</p>
                <p class="sellerregister">Register as Seller <a href="sellerregistration.php">Here</a>.</p>
            </form>
        </div>

    <div>
        <div title='About' ><a href="about.php" class='aboutinfo fixd' id='info' name='info' ><i class='fas fa-info-circle'></i></a>
    </div>

</body>
</html>