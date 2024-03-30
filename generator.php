<?php
    session_start();
    
    if(!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
        $_SESSION["error"] = "Vous devrez être connecté afin d'accéder à cette page !";
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de mème</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="./assets/generator.css">
</head>
<body>
    
    <div class="box">

        <h1>
            Générateur de mème
            <a href="controllers/logout.php"><button class="btn-sm">Déconnexion</button></a>
            <a href="memes.php"><button class="btn-sm">Mes mèmes</button></a>
        </h1>

        <div class="canvasWrapper">
            <div id="canvasDiv"></div>
        </div>

        <div class="settingsDiv">
            <div class="box">
                <div>
                    <h3>Charger une image</h3>
                    <input id="imgFile" type="file" accept="image/*"/>
                    <label for="imgFile" class="btn"><i class="fa fa-upload fa-fw fa-2x"></i></label>
                </div>
            </div>

            <h3>Texte du mème</h3>
            <div class="box">

                <p>Texte de haut</p>
                <input id="textTop" type="text" class="block" />
                
                <p>Texte de bas</p>
                <input id="textBottom" type="text" class="block" />

            </div>

            <h3>Taille du texte</h3>
            <div class="box">
                <div class="range">
                    <p>Texte de haut : <span id="textSizeTopOut">10</span></p>
                    <input id="textSizeTop" type="range" min="2" max="50" step="2" />
                </div>
            
                <div class="range">
                    <p>Texte de bas : <span id="textSizeBottomOut">10</span></p>
                    <input id="textSizeBottom" type="range" min="2" max="50" step="2" />
                </div>
                
            </div>

            <div class="box">
                <div style="display: none;" class="action">
                    <h3>Taille réelle</h3>
                    <input style="display: none;" id="trueSize" type="checkbox"/>
                    <label for="trueSize">
                        <button><i class="fa fa-check fa-fw fa-2x" aria-hidden="true"></i></button>
                    </label>
                </div>
                <div class="action">
                    <h3>Télécharger</h3>
                    <button id="export"><i class="fa fa-download fa-fw fa-2x" aria-hidden="true"></i></button>
                </div >
                <div class="action">
                    <h3>Sauvegarder</h3>
                    <button id="save"><i class="fa fa-save fa-fw fa-2x" aria-hidden="true"></i></button>
                </div>
            </div>

        </div>
    </div>

    <script  src="./assets/generator.js"></script>

</body>
</html>