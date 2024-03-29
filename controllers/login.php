<?php
session_start();

include_once '../classes/Database.php';
include_once '../classes/User.php';

$db = (new Database())->getConnection();
$user = new User($db);

if(isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if($user->login($username, $password)) {
        $_SESSION["username"] = $username;
        $_SESSION["success"] = "Connexion réussie !";
        header("Location: ../generator.php");
        exit();
    } else {
        unset($_SESSION["success"]);
        $_SESSION["error"] = "Nom d'utilisateur ou mot de passe incorrect";
        header("Location: ../login.php");
        exit();
    }
}
?>
