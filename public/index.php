<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className); // Replace backslashes with forward slashes

    if (file_exists("../classes/$className.php")) {
        require_once("../classes/$className.php");
    }
});


require_once("../config.php");








?>

