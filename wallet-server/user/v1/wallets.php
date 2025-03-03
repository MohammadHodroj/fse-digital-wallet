<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/Wallet.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$walletModel = new Wallet();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $success = $walletModel->create($_SESSION['user_id'], $input['currency'] ?? 'USD');

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Wallet created']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create wallet']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $wallets = $walletModel->getWallets($_SESSION['user_id']);
    echo json_encode(['success' => true, 'wallets' => $wallets]);
}

?>