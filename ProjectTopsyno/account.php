<?php
require_once "auth.php";
requireLogin();
require_once "database.php";

$stmt = $pdo->prepare("SELECT id, name, email, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Account | TOPSYNO</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="shop-system.css">
<link rel="stylesheet" href="account-pages.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include "header.php"; ?>

<main class="topsyno-account-page">
<section class="account-dashboard">
<div class="account-dashboard-head">
<div>
<p class="section-label">YOUR TOPSYNO</p>
<h1>MY <span>ACCOUNT.</span></h1>
<p class="account-lead">Welcome back, <?= htmlspecialchars($user["name"]) ?>.</p>
</div>
<a href="logout.php" class="account-outline-button">LOG OUT</a>
</div>

<div class="account-dashboard-grid">
<a href="wishlist.php" class="account-dashboard-card">
<i class="bi bi-heart"></i><h3>WISHLIST</h3>
<p>View the caps you've saved.</p><span>OPEN <i class="bi bi-arrow-up-right"></i></span>
</a>

<a href="cart.php" class="account-dashboard-card">
<i class="bi bi-bag"></i><h3>YOUR CART</h3>
<p>Review your selected products.</p><span>OPEN <i class="bi bi-arrow-up-right"></i></span>
</a>

<div class="account-dashboard-card account-details-card">
<i class="bi bi-person"></i><h3>ACCOUNT DETAILS</h3>
<p><strong>Name:</strong> <?= htmlspecialchars($user["name"]) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
</div>
</div>
</section>
</main>

<?php include "footer.php"; ?>
</body>
</html>