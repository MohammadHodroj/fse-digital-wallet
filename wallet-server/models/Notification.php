<?php
require_once __DIR__ . '/../connection/database.php';

class Notification {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function create($userId, $message) {
        $stmt = $this->db->prepare("
            INSERT INTO notifications (user_id, message)
            VALUES (?, ?)
        ");
        return $stmt->execute([$userId, $message]);
    }
    
    public function getNotifications($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM notifications 
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}

?>