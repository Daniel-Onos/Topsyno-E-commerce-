<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Add Product';
$error = '';
$success = '';

// Get categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $price       = floatval($_POST['price'] ?? 0);
    $stock       = intval($_POST['stock'] ?? 0);
    $category_id = intval($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $status      = $_POST['status'] ?? 'active';

    // Create slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));

    // Handle image upload
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            $imageName = $slug . '-' . time() . '.' . $ext;
            $uploadDir = '../images/products/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        } else {
            $error = 'Only JPG, PNG or WEBP images allowed';
        }
    }

    if (!$error && $name && $price > 0) {
        $stmt = $pdo->prepare("
            INSERT INTO products (name, slug, description, price, stock, category_id, image, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $slug, $description, $price, $stock, $category_id ?: null, $imageName, $status]);

        header('Location: products.php?added=1');
        exit;
    } else {
        if (!$error) $error = 'Please fill in product name and price';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product — Topsyno Admin</title>
    <link rel="stylesheet" href="includes/admin-style.css">
    <style>
        .form-card { background: #fff; border-radius: 12px; border: 1px solid #e8e2d9; padding: 32px; max-width: 700px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #6b6560; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px 14px; border: 1px solid #ded8cf; border-radius: 8px; font-size: 14px; outline: none;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #9c88b5; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
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
                <h3 style="margin-bottom: 24px;">Add New Product</h3>

                <?php if ($error): ?>
                    <div class="error-box"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Product Name *</label>
                        <input type="text" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Price (₦) *</label>
                            <input type="number" name="price" step="0.01" required value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Stock Quantity</label>
                            <input type="number" name="stock" value="<?= htmlspecialchars($_POST['stock'] ?? '0') ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id">
                                <option value="">— Select —</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status">
                                <option value="active">Active</option>
                                <option value="draft">Draft</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Product Image</label>
                        <input type="file" name="image" accept="image/*">
                    </div>

                    <button type="submit" class="btn-save">Save Product</button>
                    <a href="products.php" class="btn-cancel">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>