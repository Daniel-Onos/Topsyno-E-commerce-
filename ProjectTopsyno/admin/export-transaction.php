<?php
require 'includes/auth.php';
require 'includes/db.php';

// Same filters as transactions page
$statusFilter = $_GET['status'] ?? '';
$methodFilter = $_GET['method'] ?? '';
$fromDate     = $_GET['from'] ?? '';
$toDate       = $_GET['to'] ?? '';
$search       = trim($_GET['search'] ?? '');

$where  = [];
$params = [];

if ($statusFilter) {
    $where[]  = "payment_status = ?";
    $params[] = $statusFilter;
}
if ($methodFilter) {
    $where[]  = "payment_method = ?";
    $params[] = $methodFilter;
}
if ($fromDate) {
    $where[]  = "DATE(created_at) >= ?";
    $params[] = $fromDate;
}
if ($toDate) {
    $where[]  = "DATE(created_at) <= ?";
    $params[] = $toDate;
}
if ($search) {
    $where[]  = "(order_number LIKE ? OR customer_name LIKE ? OR customer_email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$stmt = $pdo->prepare("SELECT * FROM orders $whereSql ORDER BY created_at DESC");
$stmt->execute($params);
$transactions = $stmt->fetchAll();

// Set headers for CSV download
$filename = 'topsyno-transactions-' . date('Y-m-d') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

// CSV Header row
fputcsv($output, [
    'Date',
    'Order Number',
    'Customer Name',
    'Customer Email',
    'Customer Phone',
    'Amount (NGN)',
    'Payment Method',
    'Payment Status',
    'Order Status',
    'City',
    'State',
    'Notes'
]);

// Data rows
foreach ($transactions as $t) {
    fputcsv($output, [
        date('Y-m-d H:i', strtotime($t['created_at'])),
        $t['order_number'],
        $t['customer_name'],
        $t['customer_email'],
        $t['customer_phone'] ?? '',
        $t['total_amount'],
        ucfirst(str_replace('_', ' ', $t['payment_method'])),
        ucfirst($t['payment_status']),
        ucfirst($t['status']),
        $t['city'] ?? '',
        $t['state'] ?? '',
        $t['notes'] ?? ''
    ]);
}

fclose($output);
exit;