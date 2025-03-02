<?php
require_once __DIR__ . '/../connection/database.php';

class Transaction {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getHistory($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM transactions 
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function create($userId, $amount, $type, $recipientId = null) {
        $stmt = $this->db->prepare("
            INSERT INTO transactions (user_id, amount, type, recipient_id)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$userId, $amount, $type, $recipientId]);
    }

    public function deposit($userId, $amount) {
    $stmt = $this->db->prepare("
        INSERT INTO transactions (user_id, amount, type)
        VALUES (?, ?, 'deposit')
    ");
    return $stmt->execute([$userId, $amount]);
    }

    public function withdraw($userId, $amount) {
    $stmt = $this->db->prepare("
        INSERT INTO transactions (user_id, amount, type)
        VALUES (?, ?, 'withdrawal')
    ");
    return $stmt->execute([$userId, $amount]);
    }

    public function transfer($senderId, $recipientId, $amount) {
    $stmt = $this->db->prepare("
        INSERT INTO transactions (user_id, amount, type, recipient_id)
        VALUES (?, ?, 'transfer', ?)
    ");
    return $stmt->execute([$senderId, $amount, 'transfer', $recipientId]);
}
}

?>