<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/Wallet.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$walletModel = new Wallet();

$success = $walletModel->updateBalance($input['wallet_id'], $input['amount']);

if ($success) {
    echo json_encode(['success' => true, 'message' => 'Balance updated']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update balance']);
}

?>