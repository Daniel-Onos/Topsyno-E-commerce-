<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Add Offline Transaction';
$error = '';

$customers = $pdo->query("SELECT id, first_name, last_name, email FROM customers ORDER BY first_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id   = intval($_POST['customer_id'] ?? 0);
    $customer_name = trim($_POST['customer_name'] ?? '');
    $customer_email= trim($_POST['customer_email'] ?? '');
    $amount        = floatval($_POST['amount'] ?? 0);
    $method        = $_POST['payment_method'] ?? 'cash';
    $status        = $_POST['payment_status'] ?? 'paid';
    $notes         = trim($_POST['notes'] ?? '');

    if ($amount <= 0) {
        $error = 'Amount must be greater than 0';
    } else {
        // Generate order number
        $order_number = 'TSN-OFF-' . time();

        if ($customer_id) {
            $cust = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
            $cust->execute([$customer_id]);
            $c = $cust->fetch();
            if ($c) {
                $customer_name  = $c['first_name'] . ' ' . $c['last_name'];
                $customer_email = $c['email'];
            }
        }

        $stmt = $pdo->prepare("
            INSERT INTO orders 
            (order_number, customer_id, customer_name, customer_email, shipping_address, total_amount, status, payment_method, payment_status, notes)
            VALUES (?, ?, ?, ?, 'Offline Sale', ?, 'delivered', ?, ?, ?)
        ");
        $stmt->execute([
            $order_number,
            $customer_id ?: null,
            $customer_name ?: 'Walk-in Customer',
            $customer_email ?: 'offline@topsyno.com',
            $amount,
            $method,
            $status,
            $notes
        ]);

        header('Location: transactions.php?added=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Offline Transaction — Topsyno</title>
    <link rel="stylesheet" href="includes/admin-style.css">
    <style>
        .form-card { background:#fff; border:1px solid #e8e2d9; border-radius:12px; padding:32px; max-width:600px; }
        .form-group { margin-bottom:18px; }
        .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:#6b6560; }
        .form-group input, .form-group select, .form-group textarea {
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
                <h3 style="margin-bottom:24px;">Add Offline Transaction</h3>

                <?php if ($error): ?>
                    <div class="error-box"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label>Select Existing Customer (optional)</label>
                        <select name="customer_id">
                            <option value="">— Walk-in / New Customer —</option>
                            <?php foreach ($customers as $c): ?>
                                <option value="<?= $c['id'] ?>">
                                    <?= htmlspecialchars($c['first_name'].' '.$c['last_name'].' ('.$c['email'].')') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Customer Name (if walk-in)</label>
                        <input type="text" name="customer_name" placeholder="e.g. Walk-in Customer">
                    </div>

                    <div class="form-group">
                        <label>Customer Email (optional)</label>
                        <input type="email" name="customer_email">
                    </div>

                    <div class="form-group">
                        <label>Amount (₦) *</label>
                        <input type="number" name="amount" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label>Payment Method</label>
                        <select name="payment_method">
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Card</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Payment Status</label>
                        <select name="payment_status">
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" rows="3" placeholder="Optional note..."></textarea>
                    </div>

                    <button type="submit" class="btn-save">Save Transaction</button>
                    <a href="transactions.php" style="margin-left:12px; color:#6b6560; text-decoration:none;">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>