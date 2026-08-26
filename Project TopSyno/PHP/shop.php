<?php
$pageTitle = "Shop | TOPSYNO";
include "header.php";
?>

<main class="shop-page">

    <!-- SHOP HERO -->
    <section class="shop-hero">
        <img
            src="https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=1800&q=90"
            alt="Fashion model wearing a cap"
        >

        <div class="shop-hero-overlay"></div>

        <div class="shop-hero-content">
            <p class="eyebrow">THE FULL ROTATION</p>

            <h1>FIND YOUR<br><span>NEXT CAP.</span></h1>

            <p>
                Everyday essentials, standout pieces and
                styles made to fit your rotation.
            </p>

            <a href="#shop-content" class="shop-hero-button">
                SHOP NOW
                <i class="bi bi-arrow-down"></i>
            </a>
        </div>
    </section>


    <!-- SHOP CONTENT -->
    <section class="shop-content" id="shop-content">

        <div class="shop-top">

            <div>
                <p class="eyebrow">EXPLORE TOPSYNO</p>
                <h2>SHOP <span>ALL.</span></h2>
            </div>

            <p class="shop-intro">
                Browse by category, discover curated collections
                or explore everything in one place.
            </p>

        </div>


        <!-- CATEGORIES -->
        <div class="shop-navigation">

            <div class="shop-nav-header">
                <h3>SHOP BY CATEGORY</h3>

                <div class="shop-nav-line"></div>
            </div>

            <div class="shop-category-links">

                <a href="collection.php?type=category&name=baseball-caps">
                    Baseball Caps
                </a>

                <a href="collection.php?type=category&name=snapbacks">
                    Snapbacks
                </a>

                <a href="collection.php?type=category&name=beanies">
                    Beanies
                </a>

                <a href="collection.php?type=category&name=bucket-hats">
                    Bucket Hats
                </a>

                <a href="collection.php?type=category&name=dad-caps">
                    Dad Caps
                </a>

                <a href="collection.php?type=category&name=corduroy-caps">
                    Corduroy Caps
                </a>

            </div>

        </div>


        <!-- COLLECTIONS -->
        <div class="collections-preview">

            <div class="shop-nav-header">
                <h3>CURATED COLLECTIONS</h3>

                <div class="shop-nav-line"></div>
            </div>

            <div class="collections-grid">

                <a
                    href="collection.php?type=collection&name=midnight"
                    class="collection-preview-card"
                >
                    <img
                        src="https://images.unsplash.com/photo-1521369909029-2afed882baee?auto=format&fit=crop&w=1000&q=85"
                        alt="Midnight Collection"
                    >

                    <div class="collection-preview-overlay">
                        <p>COLLECTION 01</p>
                        <h3>MIDNIGHT</h3>
                        <span>
                            EXPLORE
                            <i class="bi bi-arrow-up-right"></i>
                        </span>
                    </div>
                </a>


                <a
                    href="collection.php?type=collection&name=everyday"
                    class="collection-preview-card"
                >
                    <img
                        src="https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=1000&q=85"
                        alt="Everyday Collection"
                    >

                    <div class="collection-preview-overlay">
                        <p>COLLECTION 02</p>
                        <h3>EVERYDAY</h3>
                        <span>
                            EXPLORE
                            <i class="bi bi-arrow-up-right"></i>
                        </span>
                    </div>
                </a>


                <a
                    href="collection.php?type=collection&name=statement"
                    class="collection-preview-card"
                >
                    <img
                        src="https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=1000&q=85"
                        alt="Statement Collection"
                    >

                    <div class="collection-preview-overlay">
                        <p>COLLECTION 03</p>
                        <h3>STATEMENT</h3>
                        <span>
                            EXPLORE
                            <i class="bi bi-arrow-up-right"></i>
                        </span>
                    </div>
                </a>

            </div>

        </div>


        <!-- PRODUCTS AREA -->
        <div class="products-section">

            <div class="products-header">

                <div>
                    <p class="eyebrow">THE FULL DROP</p>
                    <h2>ALL <span>PRODUCTS.</span></h2>
                </div>

                <p class="product-count">Showing 1–12 of 48 products</p>

            </div>


            <div class="shop-layout">

                <!-- FILTER SIDEBAR -->
                <aside class="filter-sidebar">

                    <div class="filter-title">
                        <h3>FILTER</h3>

                        <button type="button" id="clearFilters">
                            CLEAR ALL
                        </button>
                    </div>


                    <div class="filter-group">

                        <button class="filter-heading">
                            CATEGORY
                            <i class="bi bi-plus"></i>
                        </button>

                        <div class="filter-options">

                            <label>
                                <input type="checkbox" class="filter-checkbox">
                                <span>Baseball Caps</span>
                            </label>

                            <label>
                                <input type="checkbox" class="filter-checkbox">
                                <span>Snapbacks</span>
                            </label>

                            <label>
                                <input type="checkbox" class="filter-checkbox">
                                <span>Beanies</span>
                            </label>

                            <label>
                                <input type="checkbox" class="filter-checkbox">
                                <span>Bucket Hats</span>
                            </label>

                        </div>

                    </div>


                    <div class="filter-group">

                        <button class="filter-heading">
                            COLOUR
                            <i class="bi bi-plus"></i>
                        </button>

                        <div class="filter-options colour-options">

                            <button class="colour-filter black" data-colour="Black"></button>
                            <button class="colour-filter white" data-colour="White"></button>
                            <button class="colour-filter brown" data-colour="Brown"></button>
                            <button class="colour-filter beige" data-colour="Beige"></button>

                        </div>

                    </div>


                    <div class="filter-group">

                        <button class="filter-heading">
                            PRICE
                            <i class="bi bi-plus"></i>
                        </button>

                        <div class="filter-options">

                            <label>
                                <input type="checkbox" class="filter-checkbox">
                                <span>Under £25</span>
                            </label>

                            <label>
                                <input type="checkbox" class="filter-checkbox">
                                <span>£25 – £35</span>
                            </label>

                            <label>
                                <input type="checkbox" class="filter-checkbox">
                                <span>Over £35</span>
                            </label>

                        </div>

                    </div>

                </aside>


                <!-- PRODUCT GRID -->
                <div class="products-main">

                    <div class="product-controls">

                        <button class="mobile-filter-button">
                            <i class="bi bi-sliders"></i>
                            FILTER
                        </button>

                        <div class="sort-control">

                            <label for="sortProducts">SORT BY</label>

                            <select id="sortProducts">
                                <option value="featured">Featured</option>
                                <option value="newest">Newest</option>
                                <option value="low-high">Price: Low to High</option>
                                <option value="high-low">Price: High to Low</option>
                            </select>

                        </div>

                    </div>


                    <div class="shop-product-grid">

                        <?php
                        $products = [
                            ["Classic Black", "Baseball Cap", "29.99", "https://images.unsplash.com/photo-1521369909029-2afed882baee?auto=format&fit=crop&w=700&q=85"],
                            ["Street Signal", "Snapback", "32.99", "https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=700&q=85"],
                            ["Weekend Bucket", "Bucket Hat", "27.99", "https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=700&q=85"],
                            ["Everyday Knit", "Beanie", "24.99", "https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?auto=format&fit=crop&w=700&q=85"],
                            ["Midnight Essential", "Baseball Cap", "30.99", "https://images.unsplash.com/photo-1521369909029-2afed882baee?auto=format&fit=crop&w=700&q=85"],
                            ["Off Duty", "Snapback", "33.99", "https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=700&q=85"],
                            ["Soft Structure", "Bucket Hat", "28.99", "https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=700&q=85"],
                            ["Cold Weather Club", "Beanie", "25.99", "https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?auto=format&fit=crop&w=700&q=85"]
                        ];

                        foreach ($products as $product):
                        ?>

                        <article
                            class="shop-product-card"
                            data-name="<?php echo strtolower($product[0]); ?>"
                        >

                            <div class="shop-product-image">

                                <button class="wishlist-button">
                                    <i class="bi bi-heart"></i>
                                </button>

                                <img
                                    src="<?php echo $product[3]; ?>"
                                    alt="<?php echo $product[0]; ?>"
                                >

                                <a href="product.php" class="product-quick-view">
                                    VIEW PRODUCT
                                </a>

                            </div>

                            <div class="shop-product-info">

                                <div>
                                    <p><?php echo strtoupper($product[1]); ?></p>
                                    <h3><?php echo $product[0]; ?></h3>
                                </div>

                                <strong>£<?php echo $product[2]; ?></strong>

                            </div>

                        </article>

                        <?php endforeach; ?>

                    </div>


                    <!-- PAGINATION -->
                    <div class="pagination">

                        <button class="pagination-arrow">
                            <i class="bi bi-arrow-left"></i>
                        </button>

                        <button class="page-number active">1</button>
                        <button class="page-number">2</button>
                        <button class="page-number">3</button>

                        <span>...</span>

                        <button class="page-number">6</button>

                        <button class="pagination-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>

</main>

<?php include "footer.php"; ?>