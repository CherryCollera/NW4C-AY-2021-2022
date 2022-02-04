<?php

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION['brandname'])){
    header("Location: sellerhome.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM seller WHERE email = '$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if ($result -> num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['seller_id'] = $row['id'];
        $_SESSION['seller_name'] = $row['owner_name'];
        $_SESSION['seller_email'] = $row['email'];
        $_SESSION['seller_num'] = $row['cnumber'];
        header("Location: sellerhome.php");
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
    <title>Log-in as Seller</title>
     <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<style>
    </style>
<body>
    <div id="wrapper">
        <div id="banner">
   </div>     
    
   <nav id="navigation" >
        <ul class='navUL'>
            <li class='navLI'><a class="navA" href="index.php">Home</a></li>
            <li class='navLI'><a class="navA" href="about.php">About</a></li>
        </ul>
    </nav>

        <div class="container">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="color: white; font-size: 2rem; font-weight: 800;">Login as Seller</p>
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
                <p class="admin">Log-in as Admin <a href="admin-login.php">Here</a>.</p>
            </form>
        </div>
</body>
</html>