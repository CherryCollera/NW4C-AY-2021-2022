<?php

session_start();

error_reporting(0);

$conn = mysqli_connect("sql300.epizy.com", "epiz_30362403", "2v2EpbpISg5G", "epiz_30362403_bcmp") or die ('Unable to connect');
  // "localhost", "root", "", "bcmp") or die ('Unable to connect');

if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

$select = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username' AND password = '$password' ");
$row = mysqli_fetch_array($select);

if(is_array($row)){
    $_SESSION["username"] = $row ['username'];
    $_SESSION["password"] = $row ['password'];
    header("Location: adminhome.php");
} else {
    echo "<script>alert('Invalid Username or Password')</script>";

}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in</title>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>   
   <nav id="navigation" >
        <ul class='navUL'>
            <li class='navLI'><a class="navA" href="index.php">Home</a></li>
            <li class='navLI'><a class="navA" href="about.php">About</a></li>
        </ul>
    </nav>  

<div class="container">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="color: white; font-size: 2rem; font-weight: 800;">Login as Admin</p>
                <div class="input-group">
                    <input class="inputs" type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
                </div>
                <div class="input-group">
                    <input class="inputs" type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
                </div>
                <div class="input-group">
                    <button name="submit" class="btn">Login</button>
                </div>
                <p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
                <p class="seller">Log-in as seller <a href="seller-login.php">Here</a>.</p>
            </form>
</div>

</body>
</html>