<?php
require_once __DIR__ . '/../connection/database.php';

class AdminDashboard {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getTotalUsers() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
        return $stmt->fetch()['total'];
    }

    public function getTotalTransactionVolume() {
        $stmt = $this->db->query("SELECT SUM(amount) as total FROM transactions");
        return $stmt->fetch()['total'];
    }
    
    public function getRecentTransactions($limit = 10) {
        $stmt = $this->db->prepare("
            SELECT * FROM transactions 
            ORDER BY created_at DESC 
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}

?>