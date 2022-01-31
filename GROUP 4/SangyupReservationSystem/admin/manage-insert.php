<!-- manage-insert.php -->
<?php
session_start();
include_once 'dbCon.php';
$con = connect();
    
    //add table
   



    if (isset($_POST['addItem'])){
        $location_name = $_POST['location_name'];

        $res_id = $_SESSION['id'];
        

        //$ecnpassword= md5($password);

        $checkSQL = "SELECT * FROM `locations` WHERE location_name = '$location_name';";
        $checkresult = $con->query($checkSQL);
        if ($checkresult->num_rows > 0) {
            echo '<script>alert("Location Already Exit.")</script>';
            echo '<script>window.location="menu-add.php"</script>';
        }else{
        
            $iquery="INSERT INTO `locations`(`location_name`) 
            VALUES ('$location_name');";
            if ($con->query($iquery) === TRUE) {

                echo '<script>alert("Location added successfully")</script>';
                echo '<script>window.location="menu-add.php"</script>';
            }else{
                echo '<script>alert("Unsuccessful")</script>';
                echo '<script>window.location="menu-add.php"</script>';
            }
               
                    
                
            
        }
    }
?>