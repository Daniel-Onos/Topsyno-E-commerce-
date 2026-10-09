<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Add Order';
$error = '';

$customers = $pdo->query("SELECT id, first_name, last_name, email, phone FROM customers ORDER BY first_name")->fetchAll();
$products  = $pdo->query("SELECT id, name, price, stock FROM products WHERE status = 'active' AND stock > 0 ORDER BY name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id    = intval($_POST['customer_id'] ?? 0);
    $product_id     = intval($_POST['product_id'] ?? 0);
    $quantity       = max(1, intval($_POST['quantity'] ?? 1));
    $payment_method = $_POST['payment_method'] ?? 'bank_transfer';
    $payment_status = $_POST['payment_status'] ?? 'pending';
    $order_status   = $_POST['order_status'] ?? 'pending';

    // Get customer
    $cust = null;
    if ($customer_id) {
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$customer_id]);
        $cust = $stmt->fetch();
    }

    // Get product
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        $error = 'Please select a product';
    } elseif ($product['stock'] < $quantity) {
        $error = 'Not enough stock. Available: ' . $product['stock'];
    } else {
        $total = $product['price'] * $quantity;
        $order_number = 'TSN-' . time();

        $customer_name  = $cust ? $cust['first_name'] . ' ' . $cust['last_name'] : 'Walk-in Customer';
        $customer_email = $cust ? $cust['email'] : 'walkin@topsyno.com';
        $customer_phone = $cust ? $cust['phone'] : '';

        // Create order
        $stmt = $pdo->prepare("
            INSERT INTO orders 
            (order_number, customer_id, customer_name, customer_email, customer_phone, 
             shipping_address, total_amount, status, payment_method, payment_status)
            VALUES (?, ?, ?, ?, ?, 'Manual Order', ?, ?, ?, ?)
        ");
        $stmt->execute([
            $order_number,
            $customer_id ?: null,
            $customer_name,
            $customer_email,
            $customer_phone,
            $total,
            $order_status,
            $payment_method,
            $payment_status
        ]);

        $order_id = $pdo->lastInsertId();

        // Add order item
        $stmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, product_name, quantity, price)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$order_id, $product_id, $product['name'], $quantity, $product['price']]);

        // Reduce stock
        $stmt = $pdo->prepare("UPDATE products SET stock = stock - ?, sales = sales + ? WHERE id = ?");
        $stmt->execute([$quantity, $quantity, $product_id]);

        header('Location: orders.php?added=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Order — Topsyno Admin</title>
    <link rel="stylesheet" href="includes/admin-style.css">
    <style>
        .form-card { background:#fff; border:1px solid #e8e2d9; border-radius:12px; padding:32px; max-width:600px; }
        .form-group { margin-bottom:18px; }
        .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:#6b6560; }
        .form-group input, .form-group select {
            width:100%; padding:12px 14px; border:1px solid #ded8cf; border-radius:8px; font-size:14px;
        }
        .btn-save { background:#171717; color:#fff; border:none; padding:13px 28px; border-radius:8px; font-weight:700; cursor:pointer; }
        .error-box { background:#fee2e2; color:#b91c1c; padding:12px 16px; border-radius:8px; margin-bottom:20px; }
    </style>
</head>
<body>
<div class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main-content">
        <?php include 'includes/topbar.php'; ?>
        <div class="content">
            <div class="form-card">
                <h3 style="margin-bottom:24px;">Add Manual Order</h3>

                <?php if ($error): ?>
                    <div class="error-box"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label>Customer</label>
                        <select name="customer_id">
                            <option value="">— Walk-in Customer —</option>
                            <?php foreach ($customers as $c): ?>
                                <option value="<?= $c['id'] ?>">
                                    <?= htmlspecialchars($c['first_name'].' '.$c['last_name'].' ('.$c['email'].')') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Product *</label>
                        <select name="product_id" required>
                            <option value="">— Select Product —</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= htmlspecialchars($p['name']) ?> — ₦<?= number_format($p['price'],0) ?> (Stock: <?= $p['stock'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" value="1" min="1" required>
                    </div>

                    <div class="form-group">
                        <label>Payment Method</label>
                        <select name="payment_method">
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Payment Status</label>
                        <select name="payment_status">
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Order Status</label>
                        <select name="order_status">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-save">Create Order</button>
                    <a href="orders.php" style="margin-left:12px; color:#6b6560; text-decoration:none;">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>