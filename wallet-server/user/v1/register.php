<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/User.php';

$input = json_decode(file_get_contents('php://input'), true);

try{
    $userModel = new User();
    $success = $userModel->create($input['email'], $input['phone'], $input['password']);

    if($success){
        echo json_encode(['success' => true, 'message' => 'User registered']);
    }
    else{
        echo json_encode(['success' => true, 'message' => 'Registration failed']);
    }

}
catch(Exception $e){
    echo json_encode(['success' => false, 'message' => 'Server error']);
}

?>