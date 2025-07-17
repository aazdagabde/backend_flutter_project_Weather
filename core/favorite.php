<?php
class Favorite {
    private $conn;
    private $table_name = "favorites";

    public $id;
    public $user_id;
    public $city_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lire les favoris d'un utilisateur
    function getByUser() {
        $query = "SELECT city_name FROM " . $this->table_name . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    // Ajouter un favori
    function add() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, city_name=:city_name";
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->city_name = htmlspecialchars(strip_tags($this->city_name));
        
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":city_name", $this->city_name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Supprimer un favori
    function remove() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id AND city_name = :city_name";
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->city_name = htmlspecialchars(strip_tags($this->city_name));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":city_name", $this->city_name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>