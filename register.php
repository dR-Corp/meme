<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="./assets/form.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <?php if(isset($_SESSION["error"]) && !empty($_SESSION["error"])): ?>
            <p style="font-weight: bold; color: crimson; text-align: center;"><?= $_SESSION["error"] ?></p>
        <?php endif; ?>
        <form action="./controllers/register.php" method="post">
            <div class="form-group">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group flex">
                <input type="submit" value="S'inscrire">
                <a class="btn-register" href="login.php">Se connecter</a>
            </div>
        </form>
    </div>
</body>
</html>
