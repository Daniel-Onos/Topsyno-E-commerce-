<?php
require 'includes/db.php';

$stmt = $pdo->query("
    SELECT p.*, c.name AS category_name, c.slug AS category_slug
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'active'
    ORDER BY p.created_at DESC
");
$products = $stmt->fetchAll();

foreach ($products as &$p) {
    $p['category'] = $p['category_slug'] ?? ($p['category_name'] ?? 'uncategorized');
    $p['date']     = $p['created_at'] ?? date('Y-m-d');
    $p['sales']    = (int)($p['sales'] ?? 0);
    $p['views']    = (int)($p['views'] ?? 0);
    $p['price']    = (float)($p['price'] ?? 0);

    if (!empty($p['image']) && strpos($p['image'], 'images/') === false && strpos($p['image'], 'http') !== 0) {
        $p['image'] = 'images/products/' . $p['image'];
    } elseif (empty($p['image'])) {
        $p['image'] = 'images/placeholder.png';
    }
}
unset($p);

$newArrivals = $products;
usort($newArrivals, fn($a, $b) => strtotime($b['date']) <=> strtotime($a['date']));
$newArrivals = array_slice($newArrivals, 0, 4);

$bestSellers = $products;
usort($bestSellers, fn($a, $b) => $b['sales'] <=> $a['sales']);
$bestSellers = array_slice($bestSellers, 0, 4);

$trendingCaps = $products;
usort($trendingCaps, fn($a, $b) => $b['views'] <=> $a['views']);
$trendingCaps = array_slice($trendingCaps, 0, 4);

$pageTitle = 'Topsyno — Wear Your Mood';
include 'header.php';
?>

<main class="home-2026">

    <!-- HERO: starts BELOW navbar -->
    <section class="hero home-hero-slides">
        <div class="hero-slides">

            <article class="hero-slide active">
                <div class="hero-content">
                    <p class="hero-label">NEW SEASON</p>
                    <h1>Wear your<br><span>mood</span></h1>
                    <p class="hero-description">
                        Premium headwear for every fit — quiet neutrals to loud statements.
                    </p>
                    <div class="hero-buttons">
                        <a href="shop.php" class="btn btn-primary">Shop now</a>
                    </div>
                </div>
                <div class="hero-product">
                    <img src="images/Designer.png" alt="Topsyno cap" class="hero-product-img"
                         onerror="this.style.opacity='0.3'">
                </div>
            </article>

            <article class="hero-slide">
                <div class="hero-content">
                    <p class="hero-label">ESSENTIALS</p>
                    <h1>Built for<br><span>everyday</span></h1>
                    <p class="hero-description">
                        Caps and beanies made to sit right, feel right, and finish the look.
                    </p>
                    <div class="hero-buttons">
                        <a href="shop.php" class="btn btn-primary">Explore shop</a>
                    </div>
                </div>
                <div class="hero-product">
                    <img src="images/ChatGPT Image Sep 28, 2026, 05_11_22 PM.png" alt="Topsyno beanies" class="hero-product-img"
                         onerror="this.style.opacity='0.3'">
                </div>
            </article>

            <article class="hero-slide">
                <div class="hero-content">
                    <p class="hero-label">CUSTOM</p>
                    <h1>Make it<br><span>yours</span></h1>
                    <p class="hero-description">
                        Design a piece that matches your mood — fit, colour, finish.
                    </p>
                    <div class="hero-buttons">
                        <a href="custom-cap.php" class="btn btn-primary">Custom cap</a>
                    </div>
                </div>
                <div class="hero-product">
                    <img src="images/Intimate Couple Portrait Cutout.png" alt="Custom Topsyno" class="hero-product-img"
                         onerror="this.style.opacity='0.3'">
                </div>
            </article>

        </div>

        <div class="hero-navigation">
            <button type="button" class="hero-arrow" id="prevSlide" aria-label="Previous">‹</button>
            <div class="slide-indicators">
                <button type="button" class="indicator active" data-slide="0" aria-label="Slide 1"></button>
                <button type="button" class="indicator" data-slide="1" aria-label="Slide 2"></button>
                <button type="button" class="indicator" data-slide="2" aria-label="Slide 3"></button>
            </div>
            <button type="button" class="hero-arrow" id="nextSlide" aria-label="Next">›</button>
        </div>
    </section>

    <!-- BENEFITS -->
    <section class="home-benefits">
        <div class="home-benefit">
            <i class="bi bi-award"></i>
            <div><strong>Premium build</strong><span>Quality materials</span></div>
        </div>
        <div class="home-benefit">
            <i class="bi bi-truck"></i>
            <div><strong>Fast delivery</strong><span>Ships nationwide</span></div>
        </div>
        <div class="home-benefit">
            <i class="bi bi-shield-check"></i>
            <div><strong>Secure pay</strong><span>Trusted checkout</span></div>
        </div>
        <div class="home-benefit">
            <i class="bi bi-arrow-counterclockwise"></i>
            <div><strong>Easy returns</strong><span>Hassle-free support</span></div>
        </div>
    </section>

    <!-- CATEGORY MARQUEE + QUICK VIEW HOVER -->
    <section class="home-cats">
        <div class="home-section-head">
            <div>
                <p class="home-kicker">FIND YOUR STYLE</p>
                <h2>Shop by category</h2>
            </div>
            <a href="shop.php" class="home-link">View all <i class="bi bi-arrow-up-right"></i></a>
        </div>

        <div class="cat-marquee" aria-label="Category carousel">
            <div class="cat-marquee-track">

                <a href="shop.php?category=baseball-caps" class="cat-slide-card">
                    <div class="cat-slide-img">
                        <img src="images/Discipline is the mood that builds everything_.jpg" alt="Baseball"
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover">
                            <span class="cat-quick">Quick view</span>
                            <span class="cat-shop-label">Shop Baseball</span>
                        </div>
                    </div>
                    <span>Baseball</span>
                </a>

                <a href="shop.php?category=snapbacks" class="cat-slide-card">
                    <div class="cat-slide-img">
                        <img src="images/FEATURE HEADWEAR.jpg" alt="Snapbacks"
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover">
                            <span class="cat-quick">Quick view</span>
                            <span class="cat-shop-label">Shop Snapbacks</span>
                        </div>
                    </div>
                    <span>Snapbacks</span>
                </a>

                <a href="shop.php?category=beanies" class="cat-slide-card">
                    <div class="cat-slide-img">
                        <img src="images/download (8).jpg" alt="Beanies"
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover">
                            <span class="cat-quick">Quick view</span>
                            <span class="cat-shop-label">Shop Beanies</span>
                        </div>
                    </div>
                    <span>Beanies</span>
                </a>

                <a href="shop.php?category=bucket-hats" class="cat-slide-card">
                    <div class="cat-slide-img">
                        <img src="images/download (9).jpg" alt="Bucket"
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover">
                            <span class="cat-quick">Quick view</span>
                            <span class="cat-shop-label">Shop Bucket</span>
                        </div>
                    </div>
                    <span>Bucket</span>
                </a>

                <a href="shop.php?category=dad-caps" class="cat-slide-card">
                    <div class="cat-slide-img">
                        <img src="images/Raon N234 Summer Cool Hemp Feel Basic Sexy Newsboy Cap Cabbie Golf Gatsby Driving Hat.jpg" alt="Dad caps"
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover">
                            <span class="cat-quick">Quick view</span>
                            <span class="cat-shop-label">Shop Dad caps</span>
                        </div>
                    </div>
                    <span>Dad caps</span>
                </a>

                <a href="shop.php?category=corduroy-caps" class="cat-slide-card">
                    <div class="cat-slide-img">
                        <img src="images/Danton.jpg" alt="Corduroy"
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover">
                            <span class="cat-quick">Quick view</span>
                            <span class="cat-shop-label">Shop Corduroy</span>
                        </div>
                    </div>
                    <span>Corduroy</span>
                </a>

                <!-- duplicate for seamless loop -->
                <a href="shop.php?category=baseball-caps" class="cat-slide-card" aria-hidden="true">
                    <div class="cat-slide-img">
                        <img src="images/download (12).jpg" alt=""
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover"><span class="cat-quick">Quick view</span></div>
                    </div>
                    <span>Baseball</span>
                </a>
                <a href="shop.php?category=snapbacks" class="cat-slide-card" aria-hidden="true">
                    <div class="cat-slide-img">
                        <img src="images/FEATURE HEADWEAR.jpg" alt=""
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover"><span class="cat-quick">Quick view</span></div>
                    </div>
                    <span>Snapbacks</span>
                </a>
                <a href="shop.php?category=beanies" class="cat-slide-card" aria-hidden="true">
                    <div class="cat-slide-img">
                        <img src="images/SYSTEMIC Beanie.jpg" alt=""
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover"><span class="cat-quick">Quick view</span></div>
                    </div>
                    <span>Beanies</span>
                </a>
                <a href="shop.php?category=bucket-hats" class="cat-slide-card" aria-hidden="true">
                    <div class="cat-slide-img">
                        <img src="images/bucket.png.jpg" alt=""
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover"><span class="cat-quick">Quick view</span></div>
                    </div>
                    <span>Bucket</span>
                </a>
                <a href="shop.php?category=dad-caps" class="cat-slide-card" aria-hidden="true">
                    <div class="cat-slide-img">
                        <img src="images/Raon N234 Summer Cool Hemp Feel Basic Sexy Newsboy Cap Cabbie Golf Gatsby Driving Hat.jpg" alt=""
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover"><span class="cat-quick">Quick view</span></div>
                    </div>
                    <span>Dad caps</span>
                </a>
                <a href="shop.php?category=corduroy-caps" class="cat-slide-card" aria-hidden="true">
                    <div class="cat-slide-img">
                        <img src="images/Casquette velours mouton - Noir _ Unique.jpg" alt=""
                             onerror="this.parentElement.classList.add('no-img')">
                        <div class="cat-hover"><span class="cat-quick">Quick view</span></div>
                    </div>
                    <span>Corduroy</span>
                </a>

            </div>
        </div>
    </section>

    <!-- WHAT'S HOT + WISHLIST -->
    <section class="home-hot">
        <div class="home-section-head">
            <div>
                <p class="home-kicker">WHAT'S HOT</p>
                <h2>Picked for you</h2>
            </div>
        </div>

        <div class="home-tabs">
            <button type="button" class="home-tab is-active" data-tab="new">New arrivals</button>
            <button type="button" class="home-tab" data-tab="best">Best sellers</button>
            <button type="button" class="home-tab" data-tab="trend">Trending</button>
        </div>

        <?php
        function render_home_products($list) {
            if (empty($list)) {
                echo '<p class="home-empty">No products yet.</p>';
                return;
            }
            echo '<div class="home-product-grid">';
            foreach ($list as $product) {
                $id       = (int)$product['id'];
                $name     = htmlspecialchars($product['name']);
                $price    = number_format($product['price'], 0);
                $img      = htmlspecialchars($product['image']);
                $cat      = htmlspecialchars(str_replace('-', ' ', $product['category']));
                $rawPrice = (float)$product['price'];
                echo <<<HTML
                <article class="home-card">
                    <div class="home-card-media">
                        <button type="button" class="home-wish" aria-label="Add to wishlist"
                            data-id="{$id}" data-name="{$name}" data-price="{$rawPrice}" data-image="{$img}">
                            <i class="bi bi-heart"></i>
                        </button>
                        <a href="product.php?id={$id}">
                            <img src="{$img}" alt="{$name}" loading="lazy" onerror="this.src='images/placeholder.png'">
                        </a>
                        <button type="button" class="home-add add-to-cart-button"
                            data-id="{$id}" data-name="{$name}" data-price="{$rawPrice}" data-image="{$img}">
                            Add to cart
                        </button>
                    </div>
                    <div class="home-card-body">
                        <p class="home-card-cat">{$cat}</p>
                        <h3><a href="product.php?id={$id}">{$name}</a></h3>
                        <strong>₦{$price}</strong>
                    </div>
                </article>
HTML;
            }
            echo '</div>';
        }
        ?>

        <div class="home-tab-panel is-active" data-panel="new"><?php render_home_products($newArrivals); ?></div>
        <div class="home-tab-panel" data-panel="best"><?php render_home_products($bestSellers); ?></div>
        <div class="home-tab-panel" data-panel="trend"><?php render_home_products($trendingCaps); ?></div>

        <div class="home-hot-footer">
            <a href="shop.php" class="home-btn home-btn-dark">Browse full shop</a>
        </div>
    </section>

    <!-- STORY -->
    <section class="home-story">
        <div class="home-story-grid">
            <div>
                <p class="home-kicker">OUR STORY</p>
                <h2>Small detail.<br>Full look.</h2>
            </div>
            <div>
                <p>
                    From everyday essentials to statement pieces, Topsyno is for people
                    who know the smallest detail can pull the entire fit together.
                </p>
                <div class="home-story-stats">
                    <div><strong>01</strong><span>Your style</span></div>
                    <div><strong>02</strong><span>Your fit</span></div>
                    <div><strong>03</strong><span>Your story</span></div>
                </div>
                <a href="about.php" class="home-link">About Topsyno <i class="bi bi-arrow-up-right"></i></a>
            </div>
        </div>
    </section>

</main>

<style>
:root {
    --announcement-height: 34px;
    --navbar-height: 64px;
    --header-total: calc(var(--announcement-height) + var(--navbar-height));
}

.home-2026 {
    background: var(--home-bg, #f5f1ea);
    color: var(--home-text, #171717);
    /* Hero starts BELOW fixed navbar — no overlap, no white gap */
    margin-top: 0 !important;
    padding-top: var(--header-total) !important;
}

.home-kicker {
    font-size: 11px; font-weight: 700; letter-spacing: 0.16em;
    color: #9c88b5; margin: 0 0 12px;
}
.home-section-head {
    display: flex; align-items: flex-end; justify-content: space-between;
    gap: 20px; margin-bottom: 28px; padding: 0 6%;
}
.home-section-head h2 {
    font-family: "Space Grotesk", Inter, system-ui, sans-serif;
    font-size: clamp(32px, 4vw, 48px);
    letter-spacing: -0.05em; line-height: 1.08; margin: 0;
    overflow: visible;
}
.home-link {
    font-size: 12px; font-weight: 700; letter-spacing: 0.06em;
    text-decoration: none; color: inherit; white-space: nowrap;
}
.home-link:hover { color: #9c88b5; }

.home-btn {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 14px 22px; border-radius: 999px;
    font-size: 12px; font-weight: 700; letter-spacing: 0.06em;
    text-decoration: none; transition: 0.2s ease;
}
.home-btn-dark { background: #171717; color: #fff; }
.home-btn-dark:hover { background: #9c88b5; color: #171717; }

/* Hero height = full viewport minus header (not under navbar) */
.home-hero-slides.hero,
.home-hero-slides .hero-slides,
.home-hero-slides .hero-slide {
    margin-top: 0 !important;
    min-height: calc(100vh - var(--header-total)) !important;
}
.home-hero-slides .hero-slide {
    padding: 40px 6% 48px !important;
    box-sizing: border-box;
}

/* Benefits */
.home-benefits {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px;
    background: var(--home-line, #e8e2d9);
}
.home-benefit {
    display: flex; gap: 14px; align-items: flex-start;
    padding: 22px 24px; background: var(--home-card, #faf8f5);
}
.home-benefit i { font-size: 20px; color: #9c88b5; }
.home-benefit strong { display: block; font-size: 13px; margin-bottom: 4px; }
.home-benefit span { font-size: 12px; color: var(--home-muted, #8a8279); }

/* Category marquee */
.home-cats { padding: 70px 0 40px; overflow: hidden; }
.home-cats .home-section-head { margin-bottom: 32px; }

.cat-marquee {
    overflow: hidden;
    width: 100%;
    mask-image: linear-gradient(90deg, transparent, #000 4%, #000 96%, transparent);
}
.cat-marquee-track {
    display: flex;
    gap: 18px;
    width: max-content;
    animation: catScroll 32s linear infinite;
}
.cat-marquee:hover .cat-marquee-track { animation-play-state: paused; }
@keyframes catScroll {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}
.cat-slide-card {
    flex: 0 0 200px;
    text-decoration: none;
    color: inherit;
}
.cat-slide-img {
    position: relative;
    aspect-ratio: 1 / 1.15;
    border-radius: 16px;
    overflow: hidden;
    background: var(--home-soft, #eee6dc);
    margin-bottom: 12px;
}
.cat-slide-img.no-img {
    background: linear-gradient(145deg, #e8e0d6, #d4cbc0);
}
.cat-slide-img img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}
.cat-slide-card > span {
    font-size: 14px; font-weight: 700; letter-spacing: -0.02em;
}

/* Category Quick view hover */
.cat-hover {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: rgba(17, 17, 17, 0.55);
    opacity: 0;
    transition: opacity 0.25s ease;
}
.cat-slide-card:hover .cat-hover { opacity: 1; }
.cat-quick {
    padding: 10px 16px;
    border-radius: 999px;
    background: #fff;
    color: #171717;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.06em;
}
.cat-shop-label {
    color: #fff;
    font-size: 12px;
    font-weight: 600;
}

/* Products */
.home-hot { padding: 20px 0 70px; }
.home-hot .home-tabs,
.home-hot .home-tab-panel,
.home-hot .home-hot-footer { padding-left: 6%; padding-right: 6%; }

.home-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 28px; }
.home-tab {
    padding: 10px 16px; border-radius: 999px; border: 1px solid var(--home-line, #ded8cf);
    background: var(--home-card, #fff); font-size: 12px; font-weight: 700;
    cursor: pointer; color: inherit;
}
.home-tab.is-active { background: #171717; color: #fff; border-color: #171717; }
.home-tab-panel { display: none; }
.home-tab-panel.is-active { display: block; }

.home-product-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px;
}
.home-card {
    background: var(--home-card, #fff);
    border-radius: 16px; overflow: hidden;
    border: 1px solid var(--home-line, #ebe4db);
}
.home-card-media {
    position: relative; aspect-ratio: 1 / 1.12;
    background: var(--home-soft, #eee6dc); overflow: hidden;
}
.home-card-media img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform 0.4s ease;
}
.home-card:hover .home-card-media img { transform: scale(1.05); }

/* Wishlist heart */
.home-wish {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 3;
    width: 38px;
    height: 38px;
    border: none;
    border-radius: 50%;
    background: rgba(255,255,255,0.95);
    color: #171717;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    transition: 0.2s ease;
}
.home-wish:hover,
.home-wish.is-active {
    background: #171717;
    color: #fff;
}
.home-wish i { font-size: 15px; pointer-events: none; }

.home-add {
    position: absolute; left: 12px; right: 12px; bottom: 12px;
    padding: 12px; border: none; border-radius: 10px; background: #fff;
    font-size: 11px; font-weight: 700; letter-spacing: 0.06em; cursor: pointer;
    opacity: 0; transform: translateY(8px); transition: 0.25s ease;
}
.home-card:hover .home-add { opacity: 1; transform: translateY(0); }
.home-card-body { padding: 14px 16px 18px; }
.home-card-cat {
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--home-muted, #8a8279); margin-bottom: 6px;
}
.home-card-body h3 { font-size: 15px; margin: 0 0 8px; }
.home-card-body h3 a { color: inherit; text-decoration: none; }
.home-empty { padding: 40px; text-align: center; color: var(--home-muted, #8a8279); }
.home-hot-footer { margin-top: 32px; text-align: center; }

/* Story */
.home-story { padding: 0 6% 90px; }
.home-story-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;
}
.home-story h2 {
    font-family: "Space Grotesk", Inter, system-ui, sans-serif;
    font-size: clamp(34px, 4vw, 52px);
    letter-spacing: -0.05em; line-height: 1.05; margin: 0;
}
.home-story p { color: var(--home-muted, #5c564f); line-height: 1.7; margin-bottom: 24px; }
.home-story-stats {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;
}
.home-story-stats strong { display: block; font-size: 22px; margin-bottom: 4px; }
.home-story-stats span {
    font-size: 11px; letter-spacing: 0.1em; color: var(--home-muted, #8a8279);
}

/* Dark mode */
body.dark-mode {
    --home-bg: #121212;
    --home-text: #f3efe8;
    --home-card: #1c1c1c;
    --home-soft: #2a2a2a;
    --home-line: #2e2e2e;
    --home-muted: #9a938a;
}
body.dark-mode .home-2026 { background: var(--home-bg); color: var(--home-text); }
body.dark-mode .home-benefit { background: #1a1a1a; }
body.dark-mode .home-tab { background: #1c1c1c; border-color: #333; color: #f3efe8; }
body.dark-mode .home-tab.is-active { background: #9c88b5; color: #171717; border-color: #9c88b5; }
body.dark-mode .home-card { background: #1c1c1c; border-color: #2e2e2e; }
body.dark-mode .home-btn-dark { background: #9c88b5; color: #171717; }
body.dark-mode .cat-slide-img.no-img {
    background: linear-gradient(145deg, #2a2a2a, #1a1a1a);
}
body.dark-mode .home-wish {
    background: rgba(28,28,28,0.95);
    color: #f3efe8;
}
body.dark-mode .home-wish.is-active {
    background: #9c88b5;
    color: #171717;
}

@media (max-width: 1000px) {
    .home-benefits { grid-template-columns: 1fr 1fr; }
    .home-product-grid { grid-template-columns: repeat(2, 1fr); }
    .home-story-grid { grid-template-columns: 1fr; }
    .cat-slide-card { flex-basis: 160px; }
}
@media (max-width: 600px) {
    .home-benefits { grid-template-columns: 1fr; }
    .home-add { opacity: 1; transform: none; position: static; width: calc(100% - 24px); margin: 0 12px 12px; }
}
/* =========================================================
   Hero images on the BASE + fix overlapping slides
========================================================= */
.home-hero-slides.hero {
    position: relative;
    overflow: hidden !important;
    background: #f3efe8;
}

.home-hero-slides .hero-slides {
    position: relative;
    width: 100%;
    min-height: calc(100vh - var(--header-total, 98px));
    overflow: hidden;
}

/* Only the active slide is visible */
.home-hero-slides .hero-slide {
    position: absolute !important;
    inset: 0 !important;
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    align-items: stretch !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    z-index: 1 !important;
    padding: 0 0 0 6% !important;
    margin: 0 !important;
    min-height: 100% !important;
    background: #f3efe8;
    transform: none !important;
    transition: opacity 0.45s ease, visibility 0.45s ease !important;
}

.home-hero-slides .hero-slide.active {
    position: relative !important;
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
    z-index: 2 !important;
}

.home-hero-slides .hero-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    z-index: 3;
    padding: 48px 24px 48px 0;
    max-width: 520px;
}

/* Image column: full height, image glued to bottom edge */
.home-hero-slides .hero-product {
    position: relative !important;
    height: 100% !important;
    min-height: calc(100vh - var(--header-total, 98px)) !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
    overflow: hidden !important;
}

.home-hero-slides .hero-product-img {
    position: absolute !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    top: auto !important;
    width: 100% !important;
    height: 100% !important;
    max-height: none !important;
    max-width: none !important;
    object-fit: contain !important;
    object-position: bottom center !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
}

.home-hero-slides .hero-navigation {
    position: absolute;
    bottom: 24px;
    right: 6%;
    z-index: 20;
}

@media (max-width: 900px) {
    .home-hero-slides .hero-slide {
        grid-template-columns: 1fr !important;
        padding: 24px 5% 0 !important;
    }
    .home-hero-slides .hero-product {
        min-height: 48vh !important;
        height: 48vh !important;
    }
}
</style>

<script>
/* Product tabs */
document.querySelectorAll('.home-tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
        document.querySelectorAll('.home-tab').forEach(function (t) { t.classList.remove('is-active'); });
        document.querySelectorAll('.home-tab-panel').forEach(function (p) { p.classList.remove('is-active'); });
        tab.classList.add('is-active');
        var panel = document.querySelector('[data-panel="' + tab.dataset.tab + '"]');
        if (panel) panel.classList.add('is-active');
    });
});

/* Hero slider */
(function () {
    var slides = document.querySelectorAll('.home-hero-slides .hero-slide');
    var indicators = document.querySelectorAll('.home-hero-slides .indicator');
    var current = 0;
    if (!slides.length) return;

    function goTo(i) {
        slides[current].classList.remove('active');
        if (indicators[current]) indicators[current].classList.remove('active');
        current = (i + slides.length) % slides.length;
        slides[current].classList.add('active');
        if (indicators[current]) indicators[current].classList.add('active');
    }

    var prev = document.getElementById('prevSlide');
    var next = document.getElementById('nextSlide');
    if (prev) prev.addEventListener('click', function () { goTo(current - 1); });
    if (next) next.addEventListener('click', function () { goTo(current + 1); });
    indicators.forEach(function (dot, i) {
        dot.addEventListener('click', function () { goTo(i); });
    });

    setInterval(function () { goTo(current + 1); }, 6000);
})();

/* Wishlist hearts */
(function () {
    var KEY = 'topsynoWishlist';
    function getWish() {
        try { return JSON.parse(localStorage.getItem(KEY)) || []; } catch (e) { return []; }
    }
    function saveWish(list) {
        localStorage.setItem(KEY, JSON.stringify(list));
    }
    document.querySelectorAll('.home-wish').forEach(function (btn) {
        var id = String(btn.dataset.id);
        var list = getWish();
        var icon = btn.querySelector('i');
        if (list.some(function (i) { return String(i.id) === id; })) {
            btn.classList.add('is-active');
            if (icon) { icon.classList.remove('bi-heart'); icon.classList.add('bi-heart-fill'); }
        }
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var list = getWish();
            var id = String(btn.dataset.id);
            var idx = list.findIndex(function (i) { return String(i.id) === id; });
            var icon = btn.querySelector('i');
            if (idx > -1) {
                list.splice(idx, 1);
                btn.classList.remove('is-active');
                if (icon) { icon.classList.remove('bi-heart-fill'); icon.classList.add('bi-heart'); }
            } else {
                list.push({
                    id: btn.dataset.id,
                    name: btn.dataset.name,
                    price: Number(btn.dataset.price),
                    image: btn.dataset.image
                });
                btn.classList.add('is-active');
                if (icon) { icon.classList.remove('bi-heart'); icon.classList.add('bi-heart-fill'); }
            }
            saveWish(list);
        });
    });
})();
</script>

<script src="app.js"></script>
<script src="shop-system.js"></script>

<?php include 'footer.php'; ?>
