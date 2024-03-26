<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && isset($_POST['text'])) {
    
        $image = $_FILES['image'];
        $text = $_POST['text'];

        // Vérifier si le fichier est une image
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if(!in_array($image['type'], $allowed_types)) {
            die('Le fichier téléchargé n\'est pas une image.');
        }

        // Télécharger l'image sur le serveur
        $upload_dir = 'uploads/';
        $filename = $upload_dir . basename($image['name']);
        if(move_uploaded_file($image['tmp_name'], $filename)) {
            // Ajouter du texte à l'image (exemple simple)
            $image_data = imagecreatefromjpeg($filename);
            $text_color = imagecolorallocate($image_data, 255, 255, 255); // Couleur du texte (blanc)
            imagettftext($image_data, 30, 0, 20, 40, $text_color, 'C:\Windows\Fonts\arial.ttf', $text); // Ajouter du texte en haut à gauche

            // Générer le mème
            $meme_filename = $upload_dir . 'meme_' . uniqid() . '.jpg';
            imagejpeg($image_data, $meme_filename);

            // Rediriger vers la page avec le mème généré
            header('Location: index.php?meme_url=' . $meme_filename);
            exit;
        } else {
            die('Une erreur s\'est produite lors du téléchargement du fichier.');
        }
    } else {
        die('Accès non autorisé.');
    }
?>
