<?php
    
    if(isset($_GET['id'])){
        include 'dbCon.php';
        $con = connect();

        $id = $_GET['id'];
        $stocks = $_GET['stock'];
        $oldstock = 0;

        $sql = "SELECT * FROM `menu_item` WHERE id = '$id'";
        $result = $con->query($sql);

        foreach ($result as $r) {
            $oldstock =  $r['stocks'];
        }

        $newstock = (int)$oldstock + (int)$stocks;

        $stmt = $con->prepare("UPDATE `menu_item` SET `stocks`='$newstock' where id ='$id'");
        $stmt->execute();
        $stmt->close();
        $con->close();

        echo "success";
    } 