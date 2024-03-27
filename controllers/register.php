<?php
session_start();

include_once '../classes/Database.php';
include_once '../classes/User.php';

$db = (new Database("meme"))->getConnection();
$user = new User($db);

if(isset($_POST["username"]) && isset($_POST["name"]) && isset($_POST["password"])) {

    $username = $_POST["username"];
    $name = $_POST["name"];
    $password = $_POST["password"];

    if($user->register($username, $name, $password)) {
        $_SESSION["success"] = "inscription effectuée avec succès, connectez vous !";
        header("Location: ../login.php");
        exit();
    }
    else {
        $_SESSION["error"] = "Une erreur est survenue, veuillez recommencer !";
        header("Location: ../register.php");
        unset($_SESSION["success"]);
        exit();
    }

}


?>