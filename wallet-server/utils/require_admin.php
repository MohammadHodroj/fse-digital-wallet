<?php
require_once __DIR__ . '/auth.php';

if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Admin access required']);
    exit;
}

?>