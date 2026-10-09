<?php
require 'includes/auth.php';
require 'includes/db.php';

$pageTitle = 'Products';

// Get products with category
$products = $pdo->query("
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    ORDER BY p.created_at DESC
")->fetchAll();

// Stats
$totalProducts = count($products);
$totalStock    = $pdo->query("SELECT COALESCE(SUM(stock), 0) FROM products")->fetchColumn();
$outOfStock    = $pdo->query("SELECT COUNT(*) FROM products WHERE stock = 0")->fetchColumn();
$lowStock      = $pdo->query("SELECT COUNT(*) FROM products WHERE stock > 0 AND stock <= 10")->fetchColumn();
$totalValue    = $pdo->query("SELECT COALESCE(SUM(price * stock), 0) FROM products")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products — Topsyno Admin</title>
    <link rel="stylesheet" href="includes/admin-style.css">
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #e8e2d9;
            border-radius: 12px;
            padding: 20px;
        }
        .stat-card.warning {
            background: #fef3c7;
            border-color: #fde68a;
        }
        .stat-card.danger {
            background: #fee2e2;
            border-color: #fecaca;
        }
        .stat-card p {
            font-size: 12px;
            color: #6b6560;
            margin-bottom: 6px;
        }
        .stat-card h3 {
            font-size: 22px;
            font-weight: 700;
        }
        .stock-low {
            color: #b45309;
            font-weight: 600;
        }
        .stock-out {
            color: #b91c1c;
            font-weight: 600;
        }
        .product-thumb {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 6px;
            background: #f0ebe3;
        }
        .btn-add {
            padding: 8px 16px;
            background: #171717;
            color: #fff;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-add:hover {
            background: #9c88b5;
            color: #171717;
        }
    </style>
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
                    <p>Total Products</p>
                    <h3><?= $totalProducts ?></h3>
                </div>
                <div class="stat-card">
                    <p>Total Stock</p>
                    <h3><?= $totalStock ?></h3>
                </div>
                <div class="stat-card warning">
                    <p>Low Stock (≤10)</p>
                    <h3><?= $lowStock ?></h3>
                </div>
                <div class="stat-card danger">
                    <p>Out of Stock</p>
                    <h3><?= $outOfStock ?></h3>
                </div>
                <div class="stat-card">
                    <p>Inventory Value</p>
                    <h3>₦<?= number_format($totalValue, 0) ?></h3>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-header">
                    <h3>All Products (Inventory)</h3>
                    <a href="add-product.php" class="btn-add">+ Add Product</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Sales</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7" style="text-align:center; padding:50px; color:#8a8279;">
                                    No products yet. Click “Add Product” to create one.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <?php
                                    $stockClass = '';
                                    if ($product['stock'] == 0) {
                                        $stockClass = 'stock-out';
                                    } elseif ($product['stock'] <= 10) {
                                        $stockClass = 'stock-low';
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:12px;">
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="../images/products/<?= htmlspecialchars($product['image']) ?>" 
                                                     class="product-thumb" 
                                                     alt=""
                                                     onerror="this.style.display='none'">
                                            <?php endif; ?>
                                            <strong><?= htmlspecialchars($product['name']) ?></strong>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($product['category_name'] ?? '—') ?></td>
                                    <td>₦<?= number_format($product['price'], 0) ?></td>
                                    <td class="<?= $stockClass ?>">
                                        <?= $product['stock'] ?>
                                        <?php if ($product['stock'] == 0): ?>
                                            <br><small>Out of stock</small>
                                        <?php elseif ($product['stock'] <= 10): ?>
                                            <br><small>Low stock</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $product['status'] === 'active' ? 'delivered' : 'pending' ?>">
                                            <?= ucfirst(str_replace('_', ' ', $product['status'])) ?>
                                        </span>
                                    </td>
                                    <td><?= $product['sales'] ?></td>
                                    <td>
                                        <a href="edit-product.php?id=<?= $product['id'] ?>" 
                                           style="color:#9c88b5; font-size:12px; margin-right:10px;">Edit</a>
                                        <a href="delete-product.php?id=<?= $product['id'] ?>" 
                                           onclick="return confirm('Delete this product?')"
                                           style="color:#b91c1c; font-size:12px;">Delete</a>
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