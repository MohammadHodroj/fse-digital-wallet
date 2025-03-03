<?php
require_once __DIR__ . '/../connection/database.php';

class Ticket {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function create($userId, $subject, $message) {
        $stmt = $this->db->prepare("
            INSERT INTO tickets (user_id, subject, message)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$userId, $subject, $message]);
    }

    public function getTickets($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM tickets 
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function updateStatus($ticketId, $status, $adminNotes = '') {
        $stmt = $this->db->prepare("
            UPDATE tickets 
            SET status = ?, admin_notes = ?
            WHERE id = ?
        ");
        return $stmt->execute([$status, $adminNotes, $ticketId]);
    }
}

?>