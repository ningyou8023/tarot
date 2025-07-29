<?php
require_once __DIR__ . '/../config/database.php';

class TarotCard {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function getAllCards() {
        $query = "SELECT * FROM tarot_cards ORDER BY type, number";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRandomCards($count = 3) {
        $query = "SELECT * FROM tarot_cards ORDER BY RAND() LIMIT :count";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':count', $count, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCardById($id) {
        $query = "SELECT * FROM tarot_cards WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>