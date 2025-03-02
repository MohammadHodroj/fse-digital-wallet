<?php
require_once __DIR__ . '/../../common/require_admin.php';
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/User.php';

$userModel = new User();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
        $users = $userModel->getAll();
        echo json_encode(['success' => true, 'data' => $users]);

    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        
        $input = json_decode(file_get_contents('php://input'), true);
        $success = $userModel->delete($input['user_id']);
        echo json_encode(['success' => $success]);
    }
} 
catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error']);
}

?>