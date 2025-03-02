<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/Transaction.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$transactionModel = new Transaction();
$transactions = $transactionModel->getHistory($_SESSION['user_id']);

echo json_encode(['success' => true, 'transactions' => $transactions]);

?>