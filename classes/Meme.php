<?php
class Meme {
    private $conn;

    // Constructeur prenant une connexion PDO
    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($top_text, $bottom_text, $top_size, $bottom_size, $img, $source_img, $username) {

        $query = "INSERT INTO memes (top_text, bottom_text, top_size, bottom_size, img, source_img, username) VALUES (:top_text, :bottom_text, :top_size, :bottom_size, :img, :source_img, :username)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':top_text', $top_text);
        $stmt->bindParam(':bottom_text', $bottom_text);
        $stmt->bindParam(':top_size', $top_size);
        $stmt->bindParam(':bottom_size', $bottom_size);
        $stmt->bindParam(':img', $image);
        $stmt->bindParam(':source_img', $original_image);

        if($stmt->execute())
            return true;
        else
            return false;

    }

    public function all($username) {
        
        $query = "SELECT * FROM memes WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $memes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $memes;

    }

}
?>
