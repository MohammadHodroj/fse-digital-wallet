<?php
require_once __DIR__ . '/../../common/require_admin.php';
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/AdminDashboard.php';

$dashboardModel = new AdminDashboard();

$data = [
    'total_users' => $dashboardModel->getTotalUsers(),
    'total_volume' => $dashboardModel->getTotalTransactionVolume(),
    'recent_transactions' => $dashboardModel->getRecentTransactions()
];

echo json_encode(['success' => true, 'data' => $data]);

?>