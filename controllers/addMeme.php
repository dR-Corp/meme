<?php
session_start();

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
    
    // Écrire les données binaires dans un fichier
    if (file_put_contents($imagePath, $imageBinary) !== false) {
        // on enregistre le meme dans ce cas
        if($meme->add($top_text, $bottom_text, $top_size, $bottom_size, $image_name, "", $username)) {
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

// if(isset($_POST["top_text"]) && isset($_POST["bottom_text"]) && isset($_POST["img"])) {

//     $top_text = $_POST["top_text"];
//     $bottom_text = $_POST["bottom_text"];
//     $top_size = $_POST["top_size"];
//     $bottom_size = $_POST["bottom_size"];
//     $img = $_POST["img"];
//     $source_img = $_POST["source_img"];
//     $username = $user;

//     if($user->register($username, $name, $password)) {
//         $_SESSION["success"] = "Mème enregistré";
//         echo json_encode([
//             "alert"=>"success",
//             "message"=>"Mème enregistré"
//         ]);
//     }
//     else {
//         $_SESSION["error"] = "L'enregistrement du mème a echoué !";
//         echo json_encode([
//             "alert"=>"error",
//             "message"=>"Mème non enregistré"
//         ]);
//     }

// }


?>