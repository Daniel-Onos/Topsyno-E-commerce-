<?php
require 'includes/auth.php';
require 'includes/db.php';

$id = intval($_GET['id'] ?? 0);

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: products.php?deleted=1');
exit;