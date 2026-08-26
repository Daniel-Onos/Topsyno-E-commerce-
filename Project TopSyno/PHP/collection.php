<?php

$type = $_GET["type"] ?? "category";
$name = $_GET["name"] ?? "all";

$displayName = ucwords(str_replace("-", " ", $name));

$pageTitle = $displayName . " | TOPSYNO";

include "header.php";

$collectionImages = [
    "baseball-caps" => "https://images.unsplash.com/photo-1521369909029-2afed882baee?auto=format&fit=crop&w=1800&q=90",
    "snapbacks" => "https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=1800&q=90",
    "beanies" => "https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?auto=format&fit=crop&w=1800&q=90",
    "bucket-hats" => "https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=1800&q=90",
    "midnight" => "https://images.unsplash.com/photo-1521369909029-2afed882baee?auto=format&fit=crop&w=1800&q=90",
    "everyday" => "https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=1800&q=90",
    "statement" => "https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=1800&q=90"
];

$heroImage =
    $collectionImages[$name]
    ?? "https://images.unsplash.com/photo-1521369909029-2afed882baee?auto=format&fit=crop&w=1800&q=90";

?>

<main class="collection-page">

    <section class="collection-hero">

        <img
            src="<?php echo $heroImage; ?>"
            alt="<?php echo $displayName; ?>"
        >

        <div class="collection-hero-overlay"></div>

        <div class="collection-hero-content">

            <p class="eyebrow">
                <?php echo strtoupper($type); ?>
            </p>

            <h1>
                <?php echo strtoupper($displayName); ?>
            </h1>

            <p>
                Explore the pieces selected for this rotation.
                Find your fit and make it yours.
            </p>

            <a href="#collection-products" class="shop-hero-button">
                EXPLORE PRODUCTS
                <i class="bi bi-arrow-down"></i>
            </a>

        </div>

    </section>


    <section
        class="collection-products-section"
        id="collection-products"
    >

        <div class="products-header">

            <div>
                <p class="eyebrow">THE ROTATION</p>
                <h2>EXPLORE <span>THE DROP.</span></h2>
            </div>

            <p class="product-count">12 products available</p>

        </div>


        <div class="collection-product-grid">

            <?php
            for ($i = 1; $i <= 8; $i++):
            ?>

            <article class="shop-product-card">

                <div class="shop-product-image">

                    <button class="wishlist-button">
                        <i class="bi bi-heart"></i>
                    </button>

                    <img
                        src="<?php echo $heroImage; ?>"
                        alt="<?php echo $displayName; ?> product"
                    >

                    <a href="product.php" class="product-quick-view">
                        VIEW PRODUCT
                    </a>

                </div>

                <div class="shop-product-info">

                    <div>
                        <p><?php echo strtoupper($displayName); ?></p>

                        <h3>
                            <?php echo $displayName; ?>
                            <?php echo $i; ?>
                        </h3>
                    </div>

                    <strong>£<?php echo 24 + $i; ?>.99</strong>

                </div>

            </article>

            <?php endfor; ?>

        </div>

    </section>

</main>

<?php include "footer.php"; ?>