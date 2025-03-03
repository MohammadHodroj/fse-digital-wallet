<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../utils/helpers.php';

$input = json_decode(file_get_contents('php://input'), true);

$errors = validateInput($input, ['email', 'phone', 'password']);
if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => $errors[0]]);
    exit;
}

$userModel = new User();
$success = $userModel->create($input['email'], $input['phone'], $input['password']);

if ($success) {
    echo json_encode(['success' => true, 'message' => 'User registered']);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed']);
}

?>