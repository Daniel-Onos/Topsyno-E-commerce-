<?php
require 'includes/db.php';

$productId = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT p.*, c.name AS category_name, c.slug AS category_slug
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.id = ? AND p.status = 'active'
");
$stmt->execute([$productId]);
$currentProduct = $stmt->fetch();

if (!$currentProduct) {
    header('Location: shop.php');
    exit;
}

// Normalize
$currentProduct['category'] = $currentProduct['category_slug'] ?? 'uncategorized';
$currentProduct['oldPrice'] = $currentProduct['compare_price'] ?? 0;
$currentProduct['rating']   = $currentProduct['rating'] ?? 4.5;

if (!empty($currentProduct['image']) && strpos($currentProduct['image'], 'images/') === false) {
    $currentProduct['image'] = 'images/products/' . $currentProduct['image'];
}

$pageTitle = $currentProduct['name'] . ' | TOPSYNO';
include 'header.php';
?>

<main class="product-page-v2">

    <div class="product-breadcrumb">

        <a href="shop.php">SHOP</a>

        <span>/</span>

        <a
            href="shop.php?category=<?php echo $currentProduct["category"]; ?>"
        >
            <?php echo strtoupper(
                str_replace(
                    "-",
                    " ",
                    $currentProduct["category"]
                )
            ); ?>
        </a>

        <span>/</span>

        <strong>
            <?php echo strtoupper(
                $currentProduct["name"]
            ); ?>
        </strong>

    </div>


    <section class="product-detail-layout">

        <div class="product-detail-image">

            <img
                src="<?php echo $currentProduct["image"]; ?>"
                alt="<?php echo htmlspecialchars(
                    $currentProduct["name"]
                ); ?>"
            >

        </div>


        <div class="product-detail-info">

            <p class="section-kicker">
                <?php echo strtoupper(
                    str_replace(
                        "-",
                        " ",
                        $currentProduct["category"]
                    )
                ); ?>
            </p>

            <h1>
                <?php echo $currentProduct["name"]; ?>
            </h1>

            <div class="product-detail-price">

                ₦<?php echo number_format(
                    $currentProduct["price"]
                ); ?>

            </div>


            <p class="product-description">

                Premium construction, everyday comfort
                and a clean silhouette designed to become
                part of your rotation.

            </p>


            <div class="quantity-control">

                <button id="decreaseQty">−</button>

                <span id="productQuantity">
                    1
                </span>

                <button id="increaseQty">+</button>

            </div>


            <button
                class="product-main-cart-button"
                id="productAddToCart"
                data-id="<?php echo $currentProduct["id"]; ?>"
                data-name="<?php echo htmlspecialchars($currentProduct["name"]); ?>"
                data-price="<?php echo $currentProduct["price"]; ?>"
                data-image="<?php echo $currentProduct["image"]; ?>"
            >
                ADD TO CART
                <i class="bi bi-bag-plus"></i>
            </button>

        </div>

    </section>

</main>


<?php include "footer.php"; ?>