<?php
require_once __DIR__ . '/../../utils/require_admin.php';
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/IdentityVerification.php';

$verificationModel = new IdentityVerification();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $verifications = $verificationModel->getPending();
    echo json_encode(['success' => true, 'verifications' => $verifications]);
}
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    $success = $verificationModel->updateStatus(
        $input['verification_id'],
        $input['status'],
        $input['admin_notes'] ?? ''
    );
    echo json_encode(['success' => $success, 'message' => 'Verification updated']);
}

?>