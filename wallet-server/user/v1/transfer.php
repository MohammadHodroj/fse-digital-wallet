<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/Transaction.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$transactionModel = new Transaction();

$success = $transactionModel->transfer(
    $_SESSION['user_id'],
    $input['recipient_id'],
    $input['amount']
);

echo json_encode(['success' => $success, 'message' => 'Transfer completed']);