<?php
require_once __DIR__ . '/../config/database.php';

class WebsiteSettings {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * 获取单个设置值
     */
    public function getSetting($key, $default = '') {
        $query = "SELECT setting_value FROM website_settings WHERE setting_key = :key";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['setting_value'] : $default;
    }
    
    /**
     * 获取多个设置值
     */
    public function getSettings($keys = []) {
        if (empty($keys)) {
            $query = "SELECT setting_key, setting_value FROM website_settings";
            $stmt = $this->db->prepare($query);
        } else {
            $placeholders = str_repeat('?,', count($keys) - 1) . '?';
            $query = "SELECT setting_key, setting_value FROM website_settings WHERE setting_key IN ($placeholders)";
            $stmt = $this->db->prepare($query);
            $stmt->execute($keys);
        }
        
        if (empty($keys)) {
            $stmt->execute();
        }
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }
    
    /**
     * 按分组获取设置
     */
    public function getSettingsByGroup($group) {
        $query = "SELECT * FROM website_settings WHERE setting_group = :group ORDER BY setting_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':group', $group);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * 获取所有设置分组
     */
    public function getAllSettingsGrouped() {
        $query = "SELECT * FROM website_settings ORDER BY setting_group, setting_name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $grouped = [];
        
        foreach ($results as $row) {
            $group = $row['setting_group'];
            $key = $row['setting_key'];
            $value = $row['setting_value'];
            
            // 处理键名映射，移除前缀以匹配设置页面期望的键名
            $mappedKey = $key;
            if (strpos($key, 'contact_') === 0) {
                $mappedKey = substr($key, 8); // 移除 'contact_' 前缀
            }
            
            $grouped[$group][$mappedKey] = $value;
        }
        
        return $grouped;
    }
    
    /**
     * 更新设置值
     */
    public function updateSetting($key, $value) {
        $query = "UPDATE website_settings SET setting_value = :value, updated_at = NOW() WHERE setting_key = :key";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':key', $key);
        
        return $stmt->execute();
    }
    
    /**
     * 批量更新设置
     */
    public function updateSettings($settings) {
        $this->db->beginTransaction();
        
        try {
            foreach ($settings as $key => $value) {
                $this->updateSetting($key, $value);
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
    
    /**
     * 添加新设置
     */
    public function addSetting($key, $value, $type = 'text', $group = 'general', $name = '', $description = '') {
        $query = "INSERT INTO website_settings (setting_key, setting_value, setting_type, setting_group, setting_name, setting_description) 
                  VALUES (:key, :value, :type, :group, :name, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':group', $group);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        
        return $stmt->execute();
    }
    
    /**
     * 删除设置
     */
    public function deleteSetting($key) {
        $query = "DELETE FROM website_settings WHERE setting_key = :key";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':key', $key);
        
        return $stmt->execute();
    }
    
    /**
     * 获取联系方式设置（专门用于前端显示）
     */
    public function getContactSettings() {
        return [
            'wechat' => $this->getSetting('contact_wechat', 'tarot_master'),
            'qq' => $this->getSetting('contact_qq', '123456789'),
            'service_hours' => $this->getSetting('service_hours', '9:00-22:00')
        ];
    }
    
    /**
     * 获取所有设置（用于前端显示）
     */
    public function getAllSettings() {
        $query = "SELECT setting_key, setting_value FROM website_settings";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $settings = [];
        
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        // 提供默认值以确保前端正常显示
        $defaults = [
            'site_title' => '神秘塔罗占卜',
            'site_subtitle' => '探索命运的奥秘，寻找人生的答案',
            'site_description' => '专业的塔罗牌占卜服务',
            'contact_wechat' => 'tarot_master',
            'contact_qq' => '123456789',
            'service_hours' => '9:00-22:00',
            'consultation_price' => '50',
            'consultation_duration' => '30',
            'service_desc' => '我们提供专业的塔罗牌占卜服务，帮助您解答人生疑惑。'
        ];
        
        // 合并默认值和数据库设置
        return array_merge($defaults, $settings);
    }
}
?>