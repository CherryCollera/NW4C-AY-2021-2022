<?php
    
    if(isset($_POST['id'])){
        include 'dbCon.php';
        $con = connect();

        $id = $_POST['id'];
        $itemname = $_POST['itemname'];
        $madeby = $_POST['madeby'];
        $foodtype = $_POST['foodtype'];
        $stocks = $_POST['stocks'];
        $price = $_POST['price'];
        $output="";
        
        $stmt = $con->prepare("UPDATE `menu_item` SET `item_name`=?,`madeby`=?,`stocks`=?, `food_type`=?,`price`=? where id =?");
        $stmt->bind_param("ssisii", $itemname, $madeby, $stocks,$foodtype, $price, $id);
        $stmt->execute();
        $stmt->close();
        $con->close();
        
        echo "updated";

    } 