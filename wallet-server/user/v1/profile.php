<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/User.php';

if(empty($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$userModel = new User();
$success = $userModel->updateProfile($_SESSION['user_id'], $input);

if($success){
    echo json_encode(['success' => true, 'message' => 'Profile Updated']);
}
else{
    echo json_encode(['success' => true, 'message' => 'Failed to update profile']);
}

?>