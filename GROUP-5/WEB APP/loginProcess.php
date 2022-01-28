<?php

session_start();

if (isset($_GET["loggedIn"])) {
    $_SESSION["loggedIn"] = true;
    header("location: /");
}