<?php
class History {
    private $conn;
    private $table_name = "history";

    public $id;
    public $user_id;
    public $city_name;
    public $temperature;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lire l'historique d'un utilisateur
    function getByUser() {
        $query = "SELECT city_name, temperature, consultation_date FROM " . $this->table_name . " WHERE user_id = ? ORDER BY consultation_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    // Ajouter une entrée à l'historique
    function add() {
       
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, city_name=:city_name, temperature=:temperature";
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->city_name = htmlspecialchars(strip_tags($this->city_name));
        $this->temperature = htmlspecialchars(strip_tags($this->temperature));
        
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":city_name", $this->city_name);
        $stmt->bindParam(":temperature", $this->temperature);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>