<?php
$pageTitle = "Shop | TOPSYNO";
require 'includes/db.php';

$search   = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : 'all';
$sort     = isset($_GET['sort']) ? $_GET['sort'] : 'default';

$stmt = $pdo->query("
    SELECT p.*, c.name AS category_name, c.slug AS category_slug
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'active'
    ORDER BY p.created_at DESC
");
$products = $stmt->fetchAll();

foreach ($products as &$p) {
    $p['category']   = $p['category_slug'] ?? 'uncategorized';
    $p['collection'] = $p['collection'] ?? 'everyday';
    $p['oldPrice']   = isset($p['compare_price']) ? (float)$p['compare_price'] : 0;
    $p['rating']     = isset($p['rating']) ? (float)$p['rating'] : 4.5;
    $p['date']       = $p['created_at'] ?? date('Y-m-d');
    $p['sales']      = (int)($p['sales'] ?? 0);
    $p['views']      = (int)($p['views'] ?? 0);
    $p['price']      = (float)($p['price'] ?? 0);

    if (!empty($p['image']) && strpos($p['image'], 'images/') === false && strpos($p['image'], 'http') !== 0) {
        $p['image'] = 'images/products/' . $p['image'];
    } elseif (empty($p['image'])) {
        $p['image'] = 'images/placeholder.png';
    }
}
unset($p);

$categories = [
    'all'            => 'All',
    'baseball-caps'  => 'Baseball',
    'snapbacks'      => 'Snapbacks',
    'beanies'        => 'Beanies',
    'bucket-hats'    => 'Bucket',
    'dad-caps'       => 'Dad Caps',
    'corduroy-caps'  => 'Corduroy',
];

$filteredProducts = $products;

if ($search !== '') {
    $filteredProducts = array_values(array_filter($filteredProducts, function ($product) use ($search) {
        return stripos($product['name'], $search) !== false
            || stripos($product['category'] ?? '', $search) !== false;
    }));
}

if ($category !== 'all') {
    $filteredProducts = array_values(array_filter($filteredProducts, function ($product) use ($category) {
        return ($product['category'] ?? '') === $category;
    }));
}

switch ($sort) {
    case 'new':
        usort($filteredProducts, fn($a, $b) => strtotime($b['date']) <=> strtotime($a['date']));
        break;
    case 'selling':
        usort($filteredProducts, fn($a, $b) => $b['sales'] <=> $a['sales']);
        break;
    case 'highest':
        usort($filteredProducts, fn($a, $b) => $b['price'] <=> $a['price']);
        break;
    case 'lowest':
        usort($filteredProducts, fn($a, $b) => $a['price'] <=> $b['price']);
        break;
}

include 'header.php';
?>

<main class="shop-page-main">

    <section class="shop-hero-bar">
        <div class="shop-hero-inner">
            <p class="shop-eyebrow">CATALOGUE</p>
            <h1>Shop all headwear</h1>
            <p class="shop-lead">Caps, beanies and statement pieces — live from inventory.</p>
        </div>
    </section>

    <section class="shop-toolbar">
        <div class="shop-cats">
            <?php foreach ($categories as $slug => $label): ?>
                <a href="shop.php?category=<?= urlencode($slug) ?><?= $search ? '&search=' . urlencode($search) : '' ?>"
                   class="shop-cat-pill <?= $category === $slug ? 'is-active' : '' ?>">
                    <?= htmlspecialchars($label) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <form class="shop-tools" method="GET" action="shop.php">
            <?php if ($category !== 'all'): ?>
                <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
            <?php endif; ?>
            <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search caps…">
            <select name="sort" onchange="this.form.submit()">
                <option value="default" <?= $sort === 'default' ? 'selected' : '' ?>>Featured</option>
                <option value="new" <?= $sort === 'new' ? 'selected' : '' ?>>Newest</option>
                <option value="selling" <?= $sort === 'selling' ? 'selected' : '' ?>>Best selling</option>
                <option value="highest" <?= $sort === 'highest' ? 'selected' : '' ?>>Price: High</option>
                <option value="lowest" <?= $sort === 'lowest' ? 'selected' : '' ?>>Price: Low</option>
            </select>
            <button type="submit">Apply</button>
        </form>
    </section>

    <section class="shop-results">
        <p class="shop-count"><?= count($filteredProducts) ?> product<?= count($filteredProducts) === 1 ? '' : 's' ?></p>

        <?php if (empty($filteredProducts)): ?>
            <div class="shop-empty">
                <h2>No products found</h2>
                <p>Try another category or clear your search.</p>
                <a href="shop.php" class="btn btn-primary">View all</a>
            </div>
        <?php else: ?>
            <div class="shop-grid">
                <?php foreach ($filteredProducts as $product): ?>
                    <article class="shop-card"
                        data-id="<?= (int)$product['id'] ?>"
                        data-name="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>"
                        data-price="<?= (float)$product['price'] ?>"
                        data-image="<?= htmlspecialchars($product['image'], ENT_QUOTES) ?>">

                        <div class="shop-card-media">
                            <?php if (!empty($product['oldPrice']) && $product['oldPrice'] > $product['price']): ?>
                                <span class="shop-badge sale">Sale</span>
                            <?php elseif ((int)($product['sales'] ?? 0) > 40): ?>
                                <span class="shop-badge hot">Hot</span>
                            <?php else: ?>
                                <span class="shop-badge new">New</span>
                            <?php endif; ?>

                            <a href="product.php?id=<?= (int)$product['id'] ?>">
                                <img src="<?= htmlspecialchars($product['image']) ?>"
                                     alt="<?= htmlspecialchars($product['name']) ?>"
                                     loading="lazy"
                                     onerror="this.src='images/placeholder.png'">
                            </a>

                            <button type="button" class="shop-quick-add add-to-cart-button"
                                data-id="<?= (int)$product['id'] ?>"
                                data-name="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>"
                                data-price="<?= (float)$product['price'] ?>"
                                data-image="<?= htmlspecialchars($product['image'], ENT_QUOTES) ?>">
                                Add to cart
                            </button>
                        </div>

                        <div class="shop-card-body">
                            <p class="shop-card-cat"><?= htmlspecialchars(str_replace('-', ' ', $product['category'])) ?></p>
                            <h3>
                                <a href="product.php?id=<?= (int)$product['id'] ?>">
                                    <?= htmlspecialchars($product['name']) ?>
                                </a>
                            </h3>
                            <div class="shop-card-price">
                                <strong>₦<?= number_format($product['price'], 0) ?></strong>
                                <?php if (!empty($product['oldPrice']) && $product['oldPrice'] > $product['price']): ?>
                                    <s>₦<?= number_format($product['oldPrice'], 0) ?></s>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

</main>

<style>
.shop-page-main { background: #f5f1ea; min-height: 70vh; padding-bottom: 80px; }
.shop-hero-bar {
    padding: calc(var(--announcement-height, 30px) + var(--navbar-height, 72px) + 40px) 6% 36px;
    background: #171717;
    color: #fff;
}
.shop-eyebrow { font-size: 11px; letter-spacing: 0.18em; font-weight: 700; color: #9c88b5; margin-bottom: 10px; }
.shop-hero-bar h1 {
    font-family: "Space Grotesk", Inter, sans-serif;
    font-size: clamp(36px, 6vw, 64px);
    letter-spacing: -0.05em;
    line-height: 0.95;
    margin: 0 0 12px;
}
.shop-lead { color: #b0a99f; max-width: 420px; font-size: 15px; }
.shop-toolbar {
    display: flex; flex-wrap: wrap; gap: 16px; align-items: center; justify-content: space-between;
    padding: 22px 6%; border-bottom: 1px solid #e4ded5; background: #fff;
}
.shop-cats { display: flex; flex-wrap: wrap; gap: 8px; }
.shop-cat-pill {
    padding: 8px 14px; border-radius: 999px; border: 1px solid #ded8cf;
    font-size: 12px; font-weight: 600; text-decoration: none; color: #171717; background: #fff;
}
.shop-cat-pill.is-active, .shop-cat-pill:hover { background: #171717; color: #fff; border-color: #171717; }
.shop-tools { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
.shop-tools input, .shop-tools select {
    padding: 10px 12px; border: 1px solid #ded8cf; border-radius: 8px; font-size: 13px; background: #fff;
}
.shop-tools button {
    padding: 10px 16px; background: #171717; color: #fff; border: none; border-radius: 8px;
    font-size: 12px; font-weight: 700; cursor: pointer;
}
.shop-results { padding: 28px 6% 0; }
.shop-count { font-size: 13px; color: #8a8279; margin-bottom: 18px; }
.shop-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
}
.shop-card { background: #fff; border-radius: 14px; overflow: hidden; border: 1px solid #ebe4db; }
.shop-card-media { position: relative; aspect-ratio: 1 / 1.15; background: #eee6dc; overflow: hidden; }
.shop-card-media img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .45s ease; }
.shop-card:hover .shop-card-media img { transform: scale(1.05); }
.shop-badge {
    position: absolute; top: 12px; left: 12px; z-index: 2;
    padding: 5px 10px; border-radius: 999px; font-size: 10px; font-weight: 700; letter-spacing: .06em;
    background: #171717; color: #fff;
}
.shop-badge.sale { background: #b91c1c; }
.shop-badge.hot { background: #9c88b5; color: #171717; }
.shop-quick-add {
    position: absolute; left: 12px; right: 12px; bottom: 12px; z-index: 2;
    padding: 12px; border: none; border-radius: 8px; background: #fff; color: #171717;
    font-size: 11px; font-weight: 700; letter-spacing: .06em; cursor: pointer;
    opacity: 0; transform: translateY(8px); transition: .25s ease;
}
.shop-card:hover .shop-quick-add { opacity: 1; transform: translateY(0); }
.shop-card-body { padding: 16px 16px 18px; }
.shop-card-cat { font-size: 11px; text-transform: uppercase; letter-spacing: .08em; color: #8a8279; margin-bottom: 6px; }
.shop-card-body h3 { font-size: 15px; margin: 0 0 8px; }
.shop-card-body h3 a { text-decoration: none; color: inherit; }
.shop-card-price { display: flex; gap: 10px; align-items: baseline; }
.shop-card-price strong { font-size: 15px; }
.shop-card-price s { color: #9a938a; font-size: 13px; }
.shop-empty { text-align: center; padding: 80px 20px; }
.shop-empty h2 { margin-bottom: 10px; }
.shop-empty p { color: #8a8279; margin-bottom: 20px; }
@media (max-width: 1100px) { .shop-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 700px) {
    .shop-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .shop-toolbar { flex-direction: column; align-items: stretch; }
    .shop-quick-add { opacity: 1; transform: none; position: static; margin: 0 12px 12px; width: calc(100% - 24px); }
}
</style>

<?php include 'footer.php'; ?>