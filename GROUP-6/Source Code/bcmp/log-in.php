<?php

include 'config.php';

session_start();

error_reporting(0);


if (isset($_SESSION['name'])){
    header("Location: userhome.php");
}
if (isset($_SESSION['seller_name'])){
    header("Location: sellerhome.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email = '$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if ($result -> num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_address'] = $row['address'];
        header("Location: userhome.php");
    } else {
        echo "<script>alert('Email or Password is wrong.')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
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
   <nav id="navigation" >
        <d class='userAdmtxt'><form action="mainSearch.php" method="POST" class='navUSerHome'><input name='userSearch' placeholder='Search here...' type='text' /><button name='btnuserSearch' type='submit' ><i class="fas fa-search"></i></button></form></d>
        <img  title='Home'  class='navUL' onclick="window.location.href='main.php'" style='cursor:pointer' src='BMCP.png' class='userAdmtxt' alt='log'/>
        <ul id="log">
            <li><a class='regh' href="register.php">Register</a></li>
            <li><a class='logh' href="log-in.php">Log-in</a></li>
        </ul>
    </nav>
    
        <div class="container">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="color: white; font-size: 2rem; font-weight: 800;">Login</p>
                <div class="input-group">
                    <input class="inputs" type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="input-group">
                    <input class="inputs" type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
                </div>
                <div class="input-group">
                    <button name="submit" class="btn">Login</button>
                </div>
                <p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
                <p class="seller">Log-in as seller <a href="seller-login.php">Here</a>.</p>
                <p class="admin">Log-in as Admin <a href="admin-login.php">Here</a>.</p>
            </form>
        </div>

    <div>
        <div title='About' ><a href="about.php" class='aboutinfo fixd' id='info' name='info' ><i class='fas fa-info-circle'></i></a>
    </div>

</body>
</html>