<?php 
session_start();

if(!isset($_SESSION['name'])){
    header("Location: log-in.php");
}
    // echo"<script>alert('asdasdad'); </script>";



 if(isset($_POST['btnuserSearch'])){
    $_SESSION['sql_search'] = "SELECT * FROM product_desc";
    $_SESSION['search_Category'] = "All";
 }
// if($_POST['btnCategory'] == ''){
    // $_SESSION['sql_search'] = "SELECT * FROM product_desc";
    // $_SESSION['search_Category'] = "All";
                                // }else 

if(isset($_POST['btnCategory'])){

if($_POST['btnCategory'] == ''){
    $_SESSION['sql_search'] = "SELECT * FROM product_desc";
                                    $_SESSION['search_Category'] = "All";
                                }else if($_POST['btnCategory'] == 'Bottoms'){
        $_SESSION['sql_search'] = "SELECT * FROM product_desc where prod_type = 'Bottoms'";
                                    $_SESSION['search_Category'] = "Bottoms";
                                }else if($_POST['btnCategory'] == 'Caps'){
            $_SESSION['sql_search'] = "SELECT * FROM product_desc where prod_type = 'Caps'";
                                    $_SESSION['search_Category'] = "Caps";
                                }else if($_POST['btnCategory'] == 'Hoodie'){
                $_SESSION['sql_search'] = "SELECT * FROM product_desc where prod_type = 'Hoodie'";
                                    $_SESSION['search_Category'] = "Hoodie";
                                }else if($_POST['btnCategory'] == 'Jacket'){
                    $_SESSION['sql_search'] = "SELECT * FROM product_desc where prod_type = 'Jacket'";
                                    $_SESSION['search_Category'] = "Jacket";
                                }else if($_POST['btnCategory'] == 'Shoes'){
                        $_SESSION['sql_search'] = "SELECT * FROM product_desc where prod_type = 'Shoes'";
                                    $_SESSION['search_Category'] = "Shoes";
                                }else if($_POST['btnCategory'] == 'Shorts'){
                            $_SESSION['sql_search'] = "SELECT * FROM product_desc where prod_type = 'Shorts'";
                                    $_SESSION['search_Category'] = "Shorts";
                                }else if($_POST['btnCategory'] == 'Tops'){
                                $_SESSION['sql_search'] = "SELECT * FROM product_desc where prod_type = 'Tops'";
                                    $_SESSION['search_Category'] = "Tops";
                                }else if($_POST['btnCategory'] == 'Others'){
                                    $_SESSION['sql_search'] = "SELECT * FROM product_desc where prod_type = 'Others'";
                                    $_SESSION['search_Category'] = "Others";
                                }
                                // else{
                                //     unset($_SESSION["sql_search"]);
                                //     unset($_SESSION["search_Category"]);
                                //     unset($_SESSION["product_id"]);
                                // }
}
    echo"<script>window.location.href='user-products.php' </script>";
?>