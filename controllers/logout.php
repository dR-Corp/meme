<?php
    session_start();

    if(!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
        $_SESSION["error"] = "Vous devrez être connecté afin d'effectuer cette requête !";
        header("Location: ../login.php");
        exit;
    }

    unset($_SESSION["username"]);
    unset($_SESSION["success"]);
    unset($_SESSION["error"]);

    header("Location: ../login.php");

?>