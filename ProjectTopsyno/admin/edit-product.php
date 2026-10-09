<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Edit Product';
$id = intval($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: products.php');
    exit;
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $price       = floatval($_POST['price'] ?? 0);
    $stock       = intval($_POST['stock'] ?? 0);
    $category_id = intval($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $status      = $_POST['status'] ?? 'active';

    $imageName = $product['image'];

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp'])) {
            $imageName = $product['slug'] . '-' . time() . '.' . $ext;
            $uploadDir = '../images/products/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        }
    }

    $stmt = $pdo->prepare("
        UPDATE products SET name=?, description=?, price=?, stock=?, category_id=?, image=?, status=?
        WHERE id=?
    ");
    $stmt->execute([$name, $description, $price, $stock, $category_id ?: null, $imageName, $status, $id]);

    header('Location: products.php?updated=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product — Topsyno Admin</title>
    <link rel="stylesheet" href="includes/admin-style.css">
    <style>
        .form-card { background: #fff; border-radius: 12px; border: 1px solid #e8e2d9; padding: 32px; max-width: 700px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #6b6560; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px 14px; border: 1px solid #ded8cf; border-radius: 8px; font-size: 14px;
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .btn-save { background: #171717; color: #fff; border: none; padding: 13px 28px; border-radius: 8px; font-weight: 700; cursor: pointer; }
        .btn-cancel { margin-left: 12px; color: #6b6560; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>
<div class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main-content">
        <?php include 'includes/topbar.php'; ?>
        <div class="content">
            <div class="form-card">
                <h3 style="margin-bottom: 24px;">Edit Product</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="name" required value="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Price (₦)</label>
                            <input type="number" name="price" step="0.01" required value="<?= $product['price'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" value="<?= $product['stock'] ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id">
                                <option value="">— Select —</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status">
                                <option value="active" <?= $product['status']==='active'?'selected':'' ?>>Active</option>
                                <option value="draft" <?= $product['status']==='draft'?'selected':'' ?>>Draft</option>
                                <option value="out_of_stock" <?= $product['status']==='out_of_stock'?'selected':'' ?>>Out of Stock</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Change Image (optional)</label>
                        <input type="file" name="image" accept="image/*">
                        <?php if ($product['image']): ?>
                            <p style="font-size:12px; color:#8a8279; margin-top:6px;">Current: <?= htmlspecialchars($product['image']) ?></p>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn-save">Update Product</button>
                    <a href="products.php" class="btn-cancel">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>