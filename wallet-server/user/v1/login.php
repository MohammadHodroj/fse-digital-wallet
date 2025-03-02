<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/User.php';

$input = json_decode(file_get_contents('php://input'), true);

try {
    
    $userModel = new User();
    $user = $userModel->findByEmailOrPhone($input['login']);

    if ($user && password_verify($input['password'], $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        echo json_encode([
            'success' => true,
            'role' => $user['role']
        ]);

    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}