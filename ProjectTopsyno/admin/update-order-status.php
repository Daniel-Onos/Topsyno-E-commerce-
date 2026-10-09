<?php
require 'includes/auth.php';
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id'] ?? 0);
    $status   = $_POST['status'] ?? 'pending';

    $allowed = ['pending','processing','shipped','delivered','cancelled'];
    if ($order_id && in_array($status, $allowed)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $order_id]);
    }
}

header('Location: orders.php');
exit;