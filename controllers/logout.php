<?php

    session_start();

    unset($_SESSION["username"]);
    unset($_SESSION["success"]);
    unset($_SESSION["error"]);

    header("Location: ../login.php");

?>