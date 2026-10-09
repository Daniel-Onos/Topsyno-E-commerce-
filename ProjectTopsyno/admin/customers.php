<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Customers';

$customers = $pdo->query("
    SELECT * FROM customers 
    ORDER BY created_at DESC
")->fetchAll();

$totalCustomers = count($customers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers — Topsyno Admin</title>
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
                    <p>Total Customers</p>
                    <h3><?= $totalCustomers ?></h3>
                </div>
                <div class="stat-card">
                    <p>New This Month</p>
                    <h3><?= $pdo->query("SELECT COUNT(*) FROM customers WHERE MONTH(created_at) = MONTH(CURRENT_DATE())")->fetchColumn() ?></h3>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="card" style="margin-top: 30px;">
                 <div class="card-header">
                      <h3>All Customers</h3>
              <a href="add-customer.php" style="padding: 8px 16px; background: #171717; color: #fff; border-radius: 6px; font-size: 12px; text-decoration: none;">
              + Add Customer
              </a>
            </div>

                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($customers)): ?>
                            <tr>
                                <td colspan="5" style="text-align:center; padding: 50px; color: #8a8279;">
                                    No customers yet
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']) ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($customer['email']) ?></td>
                                    <td><?= htmlspecialchars($customer['phone'] ?? '—') ?></td>
                                    <td>
                                        <?= htmlspecialchars(($customer['city'] ?? '') . ($customer['state'] ? ', ' . $customer['state'] : '')) ?: '—' ?>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($customer['created_at'])) ?></td>
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