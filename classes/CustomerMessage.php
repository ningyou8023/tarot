<?php
require_once __DIR__ . '/../config/database.php';

class CustomerMessage {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function createMessage($data) {
        $query = "INSERT INTO customer_messages (name, qq, wechat, subject, message) 
                  VALUES (:name, :qq, :wechat, :subject, :message)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':qq', $data['qq']);
        $stmt->bindParam(':wechat', $data['wechat']);
        $stmt->bindParam(':subject', $data['subject']);
        $stmt->bindParam(':message', $data['message']);
        
        return $stmt->execute();
    }
    
    public function getAllMessages($limit = 50, $offset = 0) {
        $query = "SELECT * FROM customer_messages ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateStatus($id, $status, $reply = null) {
        $query = "UPDATE customer_messages SET status = :status";
        if ($reply) {
            $query .= ", admin_reply = :reply, replied_at = NOW()";
        }
        $query .= " WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        if ($reply) {
            $stmt->bindParam(':reply', $reply);
        }
        
        return $stmt->execute();
    }
    
    public function deleteMessage($id) {
        $query = "DELETE FROM customer_messages WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>