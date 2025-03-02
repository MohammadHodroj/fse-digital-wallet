<?php
require_once __DIR__ . '/../connection/database.php';

class IdentityVerification {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function submit($userId, $documentPath) {
        $stmt = $this->db->prepare("
            INSERT INTO identity_verifications (user_id, document_path)
            VALUES (?, ?)
        ");
        return $stmt->execute([$userId, $documentPath]);
    }

    public function getStatus($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM identity_verifications 
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
}