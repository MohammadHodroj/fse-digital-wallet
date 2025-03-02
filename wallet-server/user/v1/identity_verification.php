<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/IdentityVerification.php';

if(empty($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$verificationModel = new IdentityVerification();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $success = $verificationModel->submit($_SESSION['user_id'], $input['document_path']);
    echo json_encode(['success' => $success, 'message' => 'Verification submitted']);
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $status = $verificationModel->getStatus($_SESSION['user_id']);
    echo json_encode(['success' => true, 'message' => $status]);
}

?>