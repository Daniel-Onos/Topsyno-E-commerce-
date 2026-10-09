<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Dashboard';

// Live Stats
$totalProducts   = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders     = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalCustomers  = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$totalRevenue    = $pdo->query("SELECT COALESCE(SUM(total_amount), 0) FROM orders WHERE payment_status = 'paid'")->fetchColumn();
$pendingOrders   = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
$outOfStock      = $pdo->query("SELECT COUNT(*) FROM products WHERE stock = 0 OR status = 'out_of_stock'")->fetchColumn();

// Recent orders
$recentOrders = $pdo->query("
    SELECT order_number, customer_name, total_amount, status, created_at 
    FROM orders 
    ORDER BY created_at DESC 
    LIMIT 5
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Topsyno Admin</title>
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
                    <p>Total Revenue</p>
                    <h3>₦<?= number_format($totalRevenue, 0) ?></h3>
                </div>
                <div class="stat-card">
                    <p>Total Orders</p>
                    <h3><?= $totalOrders ?></h3>
                </div>
                <div class="stat-card">
                    <p>Products</p>
                    <h3><?= $totalProducts ?></h3>
                </div>
                <div class="stat-card">
                    <p>Customers</p>
                    <h3><?= $totalCustomers ?></h3>
                </div>
                <div class="stat-card">
                    <p>Pending Orders</p>
                    <h3><?= $pendingOrders ?></h3>
                </div>
                <div class="stat-card">
                    <p>Out of Stock</p>
                    <h3><?= $outOfStock ?></h3>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card" style="margin-top: 30px;">
                <div class="card-header">
                    <h3>Recent Orders</h3>
                    <a href="orders.php">View all</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentOrders)): ?>
                            <tr>
                                <td colspan="5" style="text-align:center; padding: 40px;">No orders yet</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($order['order_number']) ?></strong></td>
                                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                    <td>₦<?= number_format($order['total_amount'], 0) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $order['status'] ?>">
                                            <?= ucfirst($order['status']) ?>
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