<?php
require_once __DIR__ . '/../config/database.php';

class Admin {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function login($username, $password) {
        $query = "SELECT * FROM admins WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['admin_id']);
    }
    
    public function logout() {
        session_destroy();
    }
    
    // 获取当前管理员信息
    public function getCurrentAdmin() {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        $query = "SELECT id, username, email, created_at FROM admins WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $_SESSION['admin_id']);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // 修改用户名
    public function updateUsername($newUsername) {
        if (!$this->isLoggedIn()) {
            return ['success' => false, 'message' => '未登录'];
        }
        
        // 检查用户名是否已存在
        $checkQuery = "SELECT id FROM admins WHERE username = :username AND id != :current_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':username', $newUsername);
        $checkStmt->bindParam(':current_id', $_SESSION['admin_id']);
        $checkStmt->execute();
        
        if ($checkStmt->fetch()) {
            return ['success' => false, 'message' => '用户名已存在'];
        }
        
        // 更新用户名
        $updateQuery = "UPDATE admins SET username = :username WHERE id = :id";
        $updateStmt = $this->db->prepare($updateQuery);
        $updateStmt->bindParam(':username', $newUsername);
        $updateStmt->bindParam(':id', $_SESSION['admin_id']);
        
        if ($updateStmt->execute()) {
            return ['success' => true, 'message' => '用户名修改成功'];
        } else {
            return ['success' => false, 'message' => '用户名修改失败'];
        }
    }
    
    // 修改密码
    public function updatePassword($currentPassword, $newPassword) {
        if (!$this->isLoggedIn()) {
            return ['success' => false, 'message' => '未登录'];
        }
        
        // 验证当前密码
        $query = "SELECT password FROM admins WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $_SESSION['admin_id']);
        $stmt->execute();
        
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$admin || !password_verify($currentPassword, $admin['password'])) {
            return ['success' => false, 'message' => '当前密码错误'];
        }
        
        // 更新密码
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE admins SET password = :password WHERE id = :id";
        $updateStmt = $this->db->prepare($updateQuery);
        $updateStmt->bindParam(':password', $hashedPassword);
        $updateStmt->bindParam(':id', $_SESSION['admin_id']);
        
        if ($updateStmt->execute()) {
            return ['success' => true, 'message' => '密码修改成功'];
        } else {
            return ['success' => false, 'message' => '密码修改失败'];
        }
    }
    
    // 修改邮箱
    public function updateEmail($newEmail) {
        if (!$this->isLoggedIn()) {
            return ['success' => false, 'message' => '未登录'];
        }
        
        // 验证邮箱格式
        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => '邮箱格式不正确'];
        }
        
        // 更新邮箱
        $updateQuery = "UPDATE admins SET email = :email WHERE id = :id";
        $updateStmt = $this->db->prepare($updateQuery);
        $updateStmt->bindParam(':email', $newEmail);
        $updateStmt->bindParam(':id', $_SESSION['admin_id']);
        
        if ($updateStmt->execute()) {
            return ['success' => true, 'message' => '邮箱修改成功'];
        } else {
            return ['success' => false, 'message' => '邮箱修改失败'];
        }
    }
}
?>