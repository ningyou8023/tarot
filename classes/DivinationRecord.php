<?php
require_once __DIR__ . '/../config/database.php';

class DivinationRecord {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function createRecord($data) {
        $query = "INSERT INTO divination_records 
                  (user_name, user_qq, user_wechat, question, spread_type, cards_drawn, interpretation) 
                  VALUES (:user_name, :user_qq, :user_wechat, :question, :spread_type, :cards_drawn, :interpretation)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_name', $data['user_name']);
        $stmt->bindParam(':user_qq', $data['user_qq']);
        $stmt->bindParam(':user_wechat', $data['user_wechat']);
        $stmt->bindParam(':question', $data['question']);
        $stmt->bindParam(':spread_type', $data['spread_type']);
        $stmt->bindParam(':cards_drawn', $data['cards_drawn']);
        $stmt->bindParam(':interpretation', $data['interpretation']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    public function getAllRecords($limit = 50, $offset = 0) {
        $query = "SELECT * FROM divination_records ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRecordById($id) {
        $query = "SELECT * FROM divination_records WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function deleteRecord($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM divination_records WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            
            // 检查是否真的删除了记录
            if ($result && $stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("删除占卜记录失败: " . $e->getMessage());
            return false;
        }
    }

}
?>