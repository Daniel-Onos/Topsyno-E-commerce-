<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Transactions';

// ===== FILTERS =====
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

// ===== STATS =====
$totalRevenue      = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE payment_status = 'paid'")->fetchColumn();
$totalTransactions = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$paidTransactions  = $pdo->query("SELECT COUNT(*) FROM orders WHERE payment_status = 'paid'")->fetchColumn();
$pendingAmount     = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE payment_status = 'pending'")->fetchColumn();

// ===== MONTHLY SALES SUMMARY (Last 6 months) =====
$monthlySales = $pdo->query("
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') AS month,
        DATE_FORMAT(created_at, '%b %Y') AS month_label,
        COUNT(*) AS total_orders,
        COALESCE(SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END), 0) AS revenue
    FROM orders
    WHERE created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(created_at, '%Y-%m'), DATE_FORMAT(created_at, '%b %Y')
    ORDER BY month DESC
")->fetchAll();

// ===== TRANSACTIONS LIST =====
$stmt = $pdo->prepare("SELECT * FROM orders $whereSql ORDER BY created_at DESC");
$stmt->execute($params);
$transactions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions — Topsyno Admin</title>
    <link rel="stylesheet" href="includes/admin-style.css">
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #e8e2d9;
            border-radius: 12px;
            padding: 22px;
        }
        .stat-card.pending {
            background: #fef3c7;
            border-color: #fde68a;
        }
        .stat-card p {
            font-size: 13px;
            color: #6b6560;
            margin-bottom: 8px;
        }
        .stat-card h3 {
            font-size: 24px;
            font-weight: 700;
        }

        /* Monthly Summary */
        .monthly-section {
            background: #fff;
            border: 1px solid #e8e2d9;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 28px;
        }
        .monthly-section h3 {
            font-size: 15px;
            margin-bottom: 18px;
        }
        .monthly-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 14px;
        }
        .month-card {
            background: #faf8f5;
            border-radius: 10px;
            padding: 16px;
            text-align: center;
        }
        .month-card .label {
            font-size: 12px;
            color: #8a8279;
            margin-bottom: 6px;
        }
        .month-card .revenue {
            font-size: 18px;
            font-weight: 700;
            color: #171717;
        }
        .month-card .orders {
            font-size: 12px;
            color: #6b6560;
            margin-top: 4px;
        }

        /* Filters */
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
            align-items: center;
        }
        .filters select,
        .filters input {
            padding: 9px 12px;
            border: 1px solid #ded8cf;
            border-radius: 8px;
            font-size: 13px;
            background: #fff;
        }
        .filters button {
            padding: 9px 16px;
            background: #171717;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-add {
            padding: 9px 16px;
            background: #9c88b5;
            color: #fff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            margin-left: auto;
        }

        .badge-paid { background: #d1fae5; color: #065f46; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-failed { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
<div class="admin-layout">

    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <?php include 'includes/topbar.php'; ?>

        <div class="content">

            <!-- Top Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <p>Total Revenue</p>
                    <h3>₦<?= number_format($totalRevenue, 0) ?></h3>
                </div>
                <div class="stat-card">
                    <p>Total Transactions</p>
                    <h3><?= $totalTransactions ?></h3>
                </div>
                <div class="stat-card">
                    <p>Paid</p>
                    <h3><?= $paidTransactions ?></h3>
                </div>
                <div class="stat-card pending">
                    <p>Pending Settlement</p>
                    <h3>₦<?= number_format($pendingAmount, 0) ?></h3>
                </div>
            </div>

            <!-- Sales Summary by Month -->
            <div class="monthly-section">
                <h3>Sales Summary by Month (Last 6 Months)</h3>
                <div class="monthly-grid">
                    <?php if (empty($monthlySales)): ?>
                        <p style="color:#8a8279; font-size:13px;">No sales data yet</p>
                    <?php else: ?>
                        <?php foreach ($monthlySales as $m): ?>
                            <div class="month-card">
                                <div class="label"><?= htmlspecialchars($m['month_label']) ?></div>
                                <div class="revenue">₦<?= number_format($m['revenue'], 0) ?></div>
                                <div class="orders"><?= $m['total_orders'] ?> order<?= $m['total_orders'] != 1 ? 's' : '' ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters + Add Offline Button -->
            <form method="GET" class="filters">
                <select name="status">
                    <option value="">All Status</option>
                    <option value="paid" <?= $statusFilter === 'paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="failed" <?= $statusFilter === 'failed' ? 'selected' : '' ?>>Failed</option>
                </select>

                <select name="method">
                    <option value="">All Methods</option>
                    <option value="bank_transfer" <?= $methodFilter === 'bank_transfer' ? 'selected' : '' ?>>Bank Transfer</option>
                    <option value="cash" <?= $methodFilter === 'cash' ? 'selected' : '' ?>>Cash</option>
                    <option value="card" <?= $methodFilter === 'card' ? 'selected' : '' ?>>Card</option>
                </select>

                <input type="date" name="from" value="<?= htmlspecialchars($fromDate) ?>">
                <input type="date" name="to" value="<?= htmlspecialchars($toDate) ?>">

                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search order or customer...">

                   <button type="submit">Filter</button>
      <a href="transactions.php" style="font-size:13px; color:#6b6560;">Reset</a>

<!-- Export Button -->
<a href="export-transactions.php?<?= http_build_query($_GET) ?>" 
   style="padding: 9px 16px; background: #171717; color: #fff; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none;">
    Export CSV
</a>

<a href="add-offline-transaction.php" class="btn-add">+ Add Offline Transaction</a>

                <!-- <a href="add-offline-transaction.php" class="btn-add">+ Add Offline Transaction</a>
            </form> -->

            <!-- Transactions Table -->
            <div class="card">
                <div class="card-header">
                    <h3>Transaction History</h3>
                    <span style="font-size:13px; color:#8a8279;">
                        Showing <?= count($transactions) ?> results
                    </span>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center; padding:50px; color:#8a8279;">
                                    No transactions found
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $t): ?>
                                <tr>
                                    <td><?= date('M d, Y', strtotime($t['created_at'])) ?></td>
                                    <td><strong><?= htmlspecialchars($t['order_number']) ?></strong></td>
                                    <td>
                                        <?= htmlspecialchars($t['customer_name']) ?><br>
                                        <small style="color:#8a8279"><?= htmlspecialchars($t['customer_email']) ?></small>
                                    </td>
                                    <td>₦<?= number_format($t['total_amount'], 0) ?></td>
                                    <td><?= ucfirst(str_replace('_', ' ', $t['payment_method'])) ?></td>
                                    <td>
                                        <form method="POST" action="update-payment-status.php" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?= $t['id'] ?>">
                                            <select name="payment_status" onchange="this.form.submit()"
                                                style="padding:5px 8px; border-radius:6px; border:1px solid #ded8cf; font-size:12px;">
                                                <option value="pending" <?= $t['payment_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="paid" <?= $t['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                                                <option value="failed" <?= $t['payment_status'] === 'failed' ? 'selected' : '' ?>>Failed</option>
                                            </select>
                                        </form>
                                    </td>
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