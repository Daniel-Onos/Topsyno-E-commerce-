<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Add Customer';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $city       = trim($_POST['city'] ?? '');
    $state      = trim($_POST['state'] ?? '');
    $address    = trim($_POST['address'] ?? '');

    if ($first_name && $last_name && $email) {
        // Check if email already exists
        $check = $pdo->prepare("SELECT id FROM customers WHERE email = ?");
        $check->execute([$email]);

        if ($check->fetch()) {
            $error = 'A customer with this email already exists';
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO customers (first_name, last_name, email, phone, city, state, address)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$first_name, $last_name, $email, $phone, $city, $state, $address]);

            header('Location: customers.php?added=1');
            exit;
        }
    } else {
        $error = 'First name, last name and email are required';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer — Topsyno Admin</title>
    <link rel="stylesheet" href="includes/admin-style.css">
    <style>
        .form-card { background: #fff; border-radius: 12px; border: 1px solid #e8e2d9; padding: 32px; max-width: 650px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #6b6560; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 12px 14px; border: 1px solid #ded8cf; border-radius: 8px; font-size: 14px; outline: none;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: #9c88b5; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .btn-save { background: #171717; color: #fff; border: none; padding: 13px 28px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; }
        .btn-save:hover { background: #9c88b5; color: #171717; }
        .btn-cancel { margin-left: 12px; color: #6b6560; text-decoration: none; font-size: 13px; }
        .error-box { background: #fee2e2; color: #b91c1c; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; }
    </style>
</head>
<body>
<div class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main-content">
        <?php include 'includes/topbar.php'; ?>
        <div class="content">
            <div class="form-card">
                <h3 style="margin-bottom: 24px;">Add New Customer</h3>

                <?php if ($error): ?>
                    <div class="error-box"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name *</label>
                            <input type="text" name="first_name" required value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Last Name *</label>
                            <input type="text" name="last_name" required value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" value="<?= htmlspecialchars($_POST['state'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" rows="3"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn-save">Save Customer</button>
                    <a href="customers.php" class="btn-cancel">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>