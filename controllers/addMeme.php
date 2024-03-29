<?php
session_start();

include_once '../classes/Database.php';
include_once '../classes/User.php';
include_once '../classes/Meme.php';

$db = (new Database())->getConnection();
$meme = new Meme($db);
$user = $_SESSION["username"];

$data = json_encode([
    "alert"=> "success",
    "message"=> "Test successful"
]);
file_put_contents("./test.txt", $data);

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