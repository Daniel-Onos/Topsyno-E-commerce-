<?php

$pageTitle = "Collections | CAPTURED";

require "shop-data.php";
include "header.php";

$activeCollection =
    $_GET["collection"] ?? "everyday";

if (!isset($collections[$activeCollection])) {
    $activeCollection = "everyday";
}

$currentCollection =
    $collections[$activeCollection];

?>

<main class="collection-page-v2">


    <section class="collection-page-hero">

        <p class="section-kicker">
            CURATED COLLECTION
        </p>

        <h1>
            <?php echo strtoupper(
                $currentCollection["title"]
            ); ?>
        </h1>

        <p>
            <?php echo $currentCollection["description"]; ?>
        </p>

    </section>


    <!-- COLLECTION SWITCHER -->
    <div class="collection-switcher">

        <?php foreach ($collections as $slug => $collection): ?>

            <a
                href="collection.php?collection=<?php echo $slug; ?>"
                class="<?php echo $activeCollection === $slug ? "active" : ""; ?>"
            >
                <?php echo $collection["title"]; ?>
            </a>

        <?php endforeach; ?>

    </div>


    <!-- SAME FILTER/SORT SYSTEM -->
    <section class="collection-products-v2">

        <div class="active-filter-row">

            <div class="collection-result-title">

                <p class="section-kicker">
                    <?php echo strtoupper(
                        $currentCollection["title"]
                    ); ?>
                </p>

                <h2>
                    THE <span>DROP.</span>
                </h2>

            </div>


            <div class="shop-controls">

                <div class="control-dropdown">

                    <button
                        class="control-button"
                        data-dropdown="collectionFilterPanel"
                    >
                        <i class="bi bi-sliders"></i>
                        FILTER
                        <i class="bi bi-chevron-down"></i>
                    </button>


                    <div
                        class="control-panel filter-panel"
                        id="collectionFilterPanel"
                    >

                        <div class="filter-block">

                            <strong>PRICE</strong>

                            <label>
                                <input
                                    type="radio"
                                    name="collectionPrice"
                                    value="all"
                                    checked
                                >
                                All prices
                            </label>

                            <label>
                                <input
                                    type="radio"
                                    name="collectionPrice"
                                    value="under-30000"
                                >
                                Under ₦30,000
                            </label>

                            <label>
                                <input
                                    type="radio"
                                    name="collectionPrice"
                                    value="over-30000"
                                >
                                Over ₦30,000
                            </label>

                        </div>

                        <button
                            class="apply-filter-button"
                            id="applyCollectionFilters"
                        >
                            APPLY FILTERS
                        </button>

                    </div>

                </div>


                <div class="control-dropdown">

                    <button
                        class="control-button"
                        data-dropdown="collectionSortPanel"
                    >
                        SORT
                        <i class="bi bi-chevron-down"></i>
                    </button>


                    <div
                        class="control-panel sort-panel"
                        id="collectionSortPanel"
                    >

                        <button data-sort="default">
                            Default sorting
                        </button>

                        <button data-sort="new">
                            New products
                        </button>

                        <button data-sort="old">
                            Old products
                        </button>

                        <button data-sort="sales">
                            Top selling
                        </button>

                        <button data-sort="rating">
                            Top rated
                        </button>

                        <button data-sort="views">
                            Most viewed
                        </button>

                        <button data-sort="high">
                            Highest price
                        </button>

                        <button data-sort="low">
                            Lowest price
                        </button>

                        <button data-sort="random">
                            Random order
                        </button>

                    </div>

                </div>

            </div>

        </div>


        <div
            class="dynamic-product-grid"
            id="collectionProductGrid"
        >

            <?php foreach ($products as $product): ?>

                <?php
                if (
                    $product["collection"]
                    !== $activeCollection
                ) {
                    continue;
                }
                ?>

                <article
                    class="shop-product-card-v2"
                    data-id="<?php echo $product["id"]; ?>"
                    data-name="<?php echo htmlspecialchars($product["name"]); ?>"
                    data-price="<?php echo $product["price"]; ?>"
                    data-rating="<?php echo $product["rating"]; ?>"
                    data-sales="<?php echo $product["sales"]; ?>"
                    data-views="<?php echo $product["views"]; ?>"
                    data-date="<?php echo $product["date"]; ?>"
                >

                    <a
                        href="product.php?id=<?php echo $product["id"]; ?>"
                        class="product-image-link"
                    >

                        <img
                            src="<?php echo $product["image"]; ?>"
                            alt="<?php echo htmlspecialchars($product["name"]); ?>"
                        >

                    </a>


                    <div class="product-card-content">

                        <p>
                            <?php echo strtoupper(
                                $activeCollection
                            ); ?>
                        </p>

                        <h3>
                            <?php echo $product["name"]; ?>
                        </h3>

                        <div class="product-price-row">

                            <strong>
                                ₦<?php echo number_format(
                                    $product["price"]
                                ); ?>
                            </strong>

                        </div>

                        <button
                            type="button"
                            class="add-to-cart-button"
                            data-id="<?php echo $product["id"]; ?>"
                            data-name="<?php echo htmlspecialchars($product["name"]); ?>"
                            data-price="<?php echo $product["price"]; ?>"
                            data-image="<?php echo $product["image"]; ?>"
                        >
                            ADD TO CART
                            <i class="bi bi-bag-plus"></i>
                        </button>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </section>

</main>


<?php include "footer.php"; ?>