<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/Wallet.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../utils/email_helper.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$walletId = $input['wallet_id'] ?? null;
$amount = $input['amount'] ?? null;
$transactionType = $input['type'] ?? 'update';

if (empty($walletId) || empty($amount)) {
    echo json_encode(['success' => false, 'message' => 'Wallet ID and amount are required']);
    exit;
}

$walletModel = new Wallet();
$userModel = new User();

$success = $walletModel->updateBalance($walletId, $amount);

if ($success) {
    $wallet = $walletModel->getWalletById($walletId);

    $user = $userModel->getUserById($_SESSION['user_id']);

    $to = $user['email'];
    $subject = "Wallet Balance Updated";
    $body = "
        <h1>Wallet Balance Updated</h1>
        <p>Hello {$user['full_name']},</p>
        <p>Your wallet balance has been updated.</p>
        <p><strong>Transaction Type:</strong> {$transactionType}</p>
        <p><strong>New Balance:</strong> {$wallet['balance']} {$wallet['currency']}</p>
        <p><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</p>
        <p>Thank you for using Digital Wallet!</p>
    ";

    if (sendEmail($to, $subject, $body)) {
        echo json_encode(['success' => true, 'message' => 'Balance updated and email sent']);
    } else {
        echo json_encode(['success' => true, 'message' => 'Balance updated, but email failed to send']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update balance']);
}

?>