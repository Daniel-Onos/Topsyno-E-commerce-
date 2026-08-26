<?php

$query = $_GET["q"] ?? "";
$pageTitle = "Search | TOPSYNO";

include "header.php";

?>

<main class="search-results-page">

    <section class="search-results-header">

        <p class="eyebrow">SEARCH RESULTS</p>

        <h1>
            RESULTS FOR
            <span>
                "<?php echo htmlspecialchars($query); ?>"
            </span>
        </h1>

    </section>


    <section class="search-results-content">

        <div class="search-result-message">
            <p>
                Showing results matching your search.
            </p>
        </div>


        <div class="shop-product-grid">

            <!-- Later, PHP/database search results go here -->

            <?php for ($i = 1; $i <= 4; $i++): ?>

            <article class="shop-product-card">

                <div class="shop-product-image">

                    <img
                        src="https://images.unsplash.com/photo-1521369909029-2afed882baee?auto=format&fit=crop&w=700&q=85"
                        alt="Search result product"
                    >

                    <a href="product.php" class="product-quick-view">
                        VIEW PRODUCT
                    </a>

                </div>

                <div class="shop-product-info">

                    <div>
                        <p>TOPSYNO CAP</p>
                        <h3>Search Result <?php echo $i; ?></h3>
                    </div>

                    <strong>£29.99</strong>

                </div>

            </article>

            <?php endfor; ?>

        </div>

    </section>

</main>

<?php include "footer.php"; ?>