<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Bank Details';

// Simple settings using a small table or just hardcode for project
// For simplicity we store in a settings table or just display editable form

// Create settings table if not exists (run once)
$pdo->exec("
    CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) UNIQUE,
        setting_value TEXT
    )
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['bank_name', 'account_name', 'account_number', 'account_type'];
    foreach ($fields as $field) {
        $value = trim($_POST[$field] ?? '');
        $stmt = $pdo->prepare("
            INSERT INTO settings (setting_key, setting_value) 
            VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE setting_value = ?
        ");
        $stmt->execute([$field, $value, $value]);
    }
    $success = true;
}

function getSetting($pdo, $key) {
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    return $row ? $row['setting_value'] : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Details — Topsyno</title>
    <link rel="stylesheet" href="includes/admin-style.css">
    <style>
        .form-card { background:#fff; border:1px solid #e8e2d9; border-radius:12px; padding:32px; max-width:550px; }
        .form-group { margin-bottom:18px; }
        .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:#6b6560; }
        .form-group input { width:100%; padding:12px 14px; border:1px solid #ded8cf; border-radius:8px; font-size:14px; }
        .btn-save { background:#171717; color:#fff; border:none; padding:13px 28px; border-radius:8px; font-weight:700; cursor:pointer; }
        .success { background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:8px; margin-bottom:20px; }
    </style>
</head>
<body>
<div class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main-content">
        <?php include 'includes/topbar.php'; ?>
        <div class="content">
            <div class="form-card">
                <h3 style="margin-bottom:24px;">Business Bank Details</h3>

                <?php if (!empty($success)): ?>
                    <div class="success">Bank details saved successfully</div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <input type="text" name="bank_name" value="<?= htmlspecialchars(getSetting($pdo, 'bank_name')) ?>" placeholder="e.g. GTBank">
                    </div>
                    <div class="form-group">
                        <label>Account Name</label>
                        <input type="text" name="account_name" value="<?= htmlspecialchars(getSetting($pdo, 'account_name')) ?>" placeholder="Topsyno Stores">
                    </div>
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="text" name="account_number" value="<?= htmlspecialchars(getSetting($pdo, 'account_number')) ?>" placeholder="0123456789">
                    </div>
                    <div class="form-group">
                        <label>Account Type</label>
                        <input type="text" name="account_type" value="<?= htmlspecialchars(getSetting($pdo, 'account_type')) ?>" placeholder="Current / Savings">
                    </div>
                    <button type="submit" class="btn-save">Save Bank Details</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>