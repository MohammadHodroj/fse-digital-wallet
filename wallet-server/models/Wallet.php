<?php
require_once __DIR__ . '/../connection/database.php';

class Wallet {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function create($userId, $currency = 'USD') {
        $stmt = $this->db->prepare("
            INSERT INTO wallets (user_id, currency)
            VALUES (?, ?)
        ");
        return $stmt->execute([$userId, $currency]);
    }

    public function getWallets($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM wallets 
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function updateBalance($walletId, $amount) {
        $stmt = $this->db->prepare("
            UPDATE wallets 
            SET balance = balance + ?
            WHERE id = ?
        ");
        return $stmt->execute([$amount, $walletId]);
    }
}

?>