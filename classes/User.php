<?php
class User {
    private $conn;

    // Constructeur prenant une connexion PDO
    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $name, $password) {
        
        if ($this->isUsernameTaken($username)) {
            return false;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, name, password) VALUES (:username, :name, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $hashed_password);

        if($stmt->execute())
            return true;
        else
            return false;
        
    }

    public function login($username, $password) {
        
        $query = "SELECT password FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password']))
            return true;
        else
            return false;

    }

    public function isUsernameTaken($username) {
        $query = "SELECT COUNT(*) as count FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

}
?>
