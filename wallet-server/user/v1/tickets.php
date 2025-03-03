<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/Ticket.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$ticketModel = new Ticket();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $success = $ticketModel->create($_SESSION['user_id'], $input['subject'], $input['message']);

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Ticket created']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create ticket']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tickets = $ticketModel->getTickets($_SESSION['user_id']);
    echo json_encode(['success' => true, 'tickets' => $tickets]);
}

?>