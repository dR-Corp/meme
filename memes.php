<?php
session_start();

include_once 'classes/Database.php';
include_once 'classes/User.php';
include_once 'classes/Meme.php';

$db = (new Database())->getConnection();
$user = $_SESSION["username"];

$meme = new Meme($db);
$list_memes = $meme->all($user);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de mème</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="./assets/memes.css">
</head>
<body>
    
    <div class="box">

        <h1>
            Mes mèmes
            <a href="controllers/logout.php"><button class="btn-sm">Déconnexion</button></a>
            <a href="generator.php"><button class="btn-sm">Nouveau</button></a>
        </h1>

        <div class="memes flex">

        <?php if(count($list_memes) == 0): ?>
            <p>Vous n'avez encore aucun mème</p>
        <?php else: ?>
            <?php foreach($list_memes as $meme): 
                $img = $meme["img"];
                // echo "<pre>"; print_r($meme); exit;
            ?>
            <div class="meme">
                <div class="img">
                    <img src="./uploads/<?=$img?>" alt="meme">
                </div>
                <div class="text">
                    <h3>Textes du mème</h3>
                    <p><?= $meme["top_text"] ?></p>
                    <p><?= $meme["bottom_text"] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        </div>
        
    </div>

    <script  src="./assets/generator.js"></script>

</body>
</html>