<?php
session_start();

if(!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    $_SESSION["error"] = "Vous devrez être connecté afin d'effectuer cette requête !";
    header("Location: ../login.php");
    exit;
}

include_once '../classes/Database.php';
include_once '../classes/User.php';
include_once '../classes/Meme.php';

$db = (new Database())->getConnection();
$meme = new Meme($db);
$username = $_SESSION["username"];

$data = file_get_contents('php://input');
$data = json_decode($data, true);

if($data == null && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(["error"=> "Erreur lors de la lecture des données json"]);
    exit;
}

extract($data);
// file_put_contents("./test.txt", $data);

if (isset($data['image']) && !empty($data['image'])) {
    // Récupérer les données de l'image
    $imageData = $data['image'];
    
    // Convertir l'URL base64 en données binaires
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $imageBinary = base64_decode($imageData);
    
    $image_name = "meme_".uniqid().'.png';
    $imagePath = '../uploads/'.$image_name;

    //Sauvegarde le l'image source
    $source_imageData = $data['source_image'];
    
    // Convertir l'URL base64 en données binaires
    $source_imageData = str_replace('data:image/png;base64,', '', $source_imageData);
    $source_imageData = str_replace(' ', '+', $source_imageData);
    $source_imageBinary = base64_decode($source_imageData);
    
    $source_image_name = "img_".uniqid().'.png';
    $source_imagePath = '../uploads/'.$source_image_name;
    
    // Écrire les données binaires dans un fichier
    if (file_put_contents($imagePath, $imageBinary) !== false) {
        // on enregistre le meme dans ce cas
        if($meme->add($top_text, $bottom_text, $top_size, $bottom_size, $image_name, $source_image_name, $username)) {
            $message = 'Meme enregistré avec succès';
        }
        else {
            $message = "Une erreur est survenue lors de l'enregistrement du meme";
        }
        
    } else {
        $message = 'Erreur lors de l\'enregistrement de l\'image sur le serveur.';
    }
} else {
    $message = 'Aucune donnée d\'image reçue.';
}

$response = [
    "alert" => "success",
    "message" => $message
];

header('Content-Type: application/json');
echo json_encode($response);


?>