<?php
require 'includes/auth.php';
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id'] ?? 0);
    $status   = $_POST['payment_status'] ?? 'pending';

    $allowed = ['pending', 'paid', 'failed'];
    if ($order_id && in_array($status, $allowed)) {
        $stmt = $pdo->prepare("UPDATE orders SET payment_status = ? WHERE id = ?");
        $stmt->execute([$status, $order_id]);
    }
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'transactions.php'));
exit;