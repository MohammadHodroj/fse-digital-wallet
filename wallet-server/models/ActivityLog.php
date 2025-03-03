<?php
require_once __DIR__ . '/../connection/database.php';

class ActivityLog {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function log($userId, $action, $details = '') {
        $stmt = $this->db->prepare("
            INSERT INTO activity_logs (user_id, action, details)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$userId, $action, $details]);
    }
    
    public function getLogs($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM activity_logs 
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}