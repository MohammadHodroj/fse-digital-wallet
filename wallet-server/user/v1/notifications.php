<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/Notification.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$notificationModel = new Notification();
$notifications = $notificationModel->getNotifications($_SESSION['user_id']);

echo json_encode(['success' => true, 'notifications' => $notifications]);

?>