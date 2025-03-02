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

if ($_SESSION['REQUEST_METHOD'] === 'POST'){
    if($input['type'] === 'deposit') {
        $success = $transactionModel->deposit($_SESSION['user_id'], $input['amount']);
    }
    elseif($input['type'] === 'withdrawal') {
        $success = $transactionModel->withdraw($_SESSION['user_id'], $input['amount']);
    }
    else {
        echo json_encode(['success' => false, 'message' => 'Invalid Transaction type']);
    }
}
elseif ($_SESSION['REQUEST_METHOD'] === 'GET') {
    $transactions = $transactionModel->getHistory($_SESSION['user_id']);
    echo json_encode(['success' => true, 'transactions' => $transactions]);
}

?>