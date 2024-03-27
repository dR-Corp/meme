<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // envisager un autoload
    include_once './classes/Database.php';
    include_once './classes/User.php';
    include_once './classes/Meme.php';
    
    // connexion à la base de données
    $database = new Database("meme");
    $conn = $database->getConnection();

    if(isset($_SESSION["username"]) && !empty($_SESSION["username"]) ) {
        header("Location: generator.php");
    }
    else {
        header("Location: login.php");
    }
    
?>