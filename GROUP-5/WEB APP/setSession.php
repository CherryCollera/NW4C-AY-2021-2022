<?php
    require_once "init.php";

    if (isset($_POST["user"])) {;
        $_SESSION["user"] = $_POST["user"];
        echo "set";
    }