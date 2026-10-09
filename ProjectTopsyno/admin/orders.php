<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Orders';

$orders = $pdo->query("
    SELECT * FROM orders 
    ORDER BY created_at DESC
")->fetchAll();

$totalOrders   = count($orders);
$pending       = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
$processing    = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'processing'")->fetchColumn();
$delivered     = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'delivered'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders — Topsyno Admin</title>
    <link rel="stylesheet" href="includes/admin-style.css">
</head>
<body>
<div class="admin-layout">

    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <?php include 'includes/topbar.php'; ?>

        <div class="content">

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <p>Total Orders</p>
                    <h3><?= $totalOrders ?></h3>
                </div>
                <div class="stat-card">
                    <p>Pending</p>
                    <h3><?= $pending ?></h3>
                </div>
                <div class="stat-card">
                    <p>Processing</p>
                    <h3><?= $processing ?></h3>
                </div>
                <div class="stat-card">
                    <p>Delivered</p>
                    <h3><?= $delivered ?></h3>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="card" style="margin-top: 30px;">
                <div class="card-header">
                    <a href="add-order.php" style="padding: 8px 16px; background: #171717; color: #fff; border-radius: 6px; font-size: 12px; text-decoration: none;">
    + Add Order
</a>
                    <h3>All Orders</h3>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center; padding: 50px; color: #8a8279;">
                                    No orders yet. Waiting for customers to place one.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($order['order_number']) ?></strong></td>
                                    <td>
                                        <?= htmlspecialchars($order['customer_name']) ?><br>
                                        <small style="color:#8a8279"><?= htmlspecialchars($order['customer_email']) ?></small>
                                    </td>
                                    <td>₦<?= number_format($order['total_amount'], 0) ?></td>
                                              <td>
    <form method="POST" action="update-order-status.php" style="display:inline;">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        <select name="status" onchange="this.form.submit()" style="padding:5px 8px; border-radius:6px; border:1px solid #ded8cf; font-size:12px;">
            <option value="pending"     <?= $order['status']==='pending'?'selected':'' ?>>Pending</option>
            <option value="processing"  <?= $order['status']==='processing'?'selected':'' ?>>Processing</option>
            <option value="shipped"     <?= $order['status']==='shipped'?'selected':'' ?>>Shipped</option>
            <option value="delivered"   <?= $order['status']==='delivered'?'selected':'' ?>>Delivered</option>
            <option value="cancelled"   <?= $order['status']==='cancelled'?'selected':'' ?>>Cancelled</option>
        </select>
    </form>
</td>
                                    <td>
                                        <span class="badge badge-<?= $order['payment_status'] === 'paid' ? 'delivered' : 'pending' ?>">
                                            <?= ucfirst($order['payment_status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</body>
</html>