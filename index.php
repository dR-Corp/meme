<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Générateur de Mèmes</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Générateur de Mèmes</h1>
    <form action="generate.php" method="post" enctype="multipart/form-data">
      <input type="file" name="image" accept="image/*" required>
      <textarea name="text" placeholder="Ajouter du texte..." required></textarea>
      <button type="submit">Générer Mème</button>
    </form>
    <?php
      if(isset($_GET['meme_url'])) {
        echo '<img src="' . $_GET['meme_url'] . '" alt="Generated Meme">';
      }
    ?>
  </div>
</body>
</html>
