<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'TOPSYNO'); ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="shop-system.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- Announcement -->
<div class="shipping-ticker announcement-bar ts-announce">
    <div class="shipping-ticker-track">
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
        <span>FREE SHIPPING ON ORDERS OVER ₦50,000</span>
    </div>
</div>

<!-- Navbar redesign -->
<header class="navbar ts-nav" id="tsNav">
    <div class="ts-nav-inner">

        <a href="index.php" class="logo ts-logo">
            TOPSYNO<span>.</span>
        </a>

        <nav class="nav-links ts-links" id="tsLinks">
            <a href="index.php" class="<?php echo ($currentPage === 'index.php') ? 'active-page' : ''; ?>">Home</a>
            <a href="shop.php" class="<?php echo ($currentPage === 'shop.php') ? 'active-page' : ''; ?>">Shop</a>
            <a href="custom-cap.php" class="<?php echo ($currentPage === 'custom-cap.php') ? 'active-page' : ''; ?>">Custom</a>
            <a href="about.php" class="<?php echo ($currentPage === 'about.php') ? 'active-page' : ''; ?>">About</a>
        </nav>

        <div class="nav-actions ts-actions">
            <button type="button" class="ts-icon-btn" id="openSearch" aria-label="Search">
                <i class="bi bi-search"></i>
            </button>

            <a href="account.php" class="ts-icon-btn <?php echo ($currentPage === 'account.php' || $currentPage === 'login.php') ? 'active-page' : ''; ?>" aria-label="Account">
                <i class="bi bi-person"></i>
            </a>

            <a href="wishlist.php" class="ts-icon-btn <?php echo ($currentPage === 'wishlist.php') ? 'active-page' : ''; ?>" aria-label="Wishlist">
                <i class="bi bi-heart"></i>
            </a>

            <a href="cart.php"
               class="cart-button ts-cart <?php echo ($currentPage === 'cart.php') ? 'active-page' : ''; ?>"
               id="cartButton"
               aria-label="Cart">
                <i class="bi bi-bag"></i>
                <span class="cart-count ts-cart-count" id="cartCount">0</span>
            </a>

            <button type="button" class="theme-toggle ts-theme" id="themeToggle" aria-label="Toggle theme">
                <i class="bi bi-moon ts-theme-moon"></i>
                <i class="bi bi-sun ts-theme-sun"></i>
            </button>

            <button type="button" class="mobile-menu ts-burger" id="mobileMenu" aria-label="Menu">
                <span></span><span></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile drawer -->
<div class="ts-drawer" id="tsDrawer" hidden>
    <div class="ts-drawer-panel">
        <div class="ts-drawer-top">
            <span class="ts-logo">TOPSYNO<span>.</span></span>
            <button type="button" class="ts-icon-btn" id="tsDrawerClose" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <nav class="ts-drawer-links">
            <a href="index.php">Home</a>
            <a href="shop.php">Shop</a>
            <a href="custom-cap.php">Custom Cap</a>
            <a href="about.php">About</a>
            <a href="cart.php">Cart</a>
            <a href="account.php">Account</a>
        </nav>
    </div>
</div>

<!-- Search overlay -->
<div class="search-overlay" id="searchOverlay">
    <button type="button" class="search-close" id="closeSearch" aria-label="Close search">
        <i class="bi bi-x-lg"></i>
    </button>
    <form class="global-search-form" id="searchForm" action="shop.php" method="GET">
        <p>SEARCH TOPSYNO</p>
        <div class="global-search-input">
            <input type="search" id="searchInput" name="search" placeholder="Search products" autocomplete="off">
            <button type="submit" aria-label="Search">SEARCH</button>
        </div>
        <div id="searchResults"></div>
    </form>
</div>

<style>
/* ===== NAVBAR REDESIGN ===== */
:root {
    --ts-nav-h: 64px;
    --ts-announce-h: 34px;
}

.ts-announce.announcement-bar {
    height: var(--ts-announce-h) !important;
    background: #111 !important;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.ts-announce .shipping-ticker-track span {
    font-size: 11px !important;
    letter-spacing: 0.12em !important;
    font-weight: 600 !important;
}

/* Bar */
.navbar.ts-nav {
    position: fixed !important;
    top: var(--ts-announce-h) !important;
    left: 0 !important;
    width: 100% !important;
    height: var(--ts-nav-h) !important;
    margin: 0 !important;
    padding: 0 !important;
    background: rgba(17, 17, 17, 0.92) !important;
    backdrop-filter: blur(14px) saturate(1.2);
    -webkit-backdrop-filter: blur(14px) saturate(1.2);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    color: #fff !important;
    z-index: 10001 !important;
    display: block !important;
    transition: background 0.25s ease, box-shadow 0.25s ease;
}
.navbar.ts-nav.is-scrolled {
    background: rgba(12, 12, 12, 0.97) !important;
    box-shadow: 0 8px 30px rgba(0,0,0,0.25);
}

.ts-nav-inner {
    height: 100%;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 5%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

/* Logo */
.ts-logo,
a.ts-logo {
    font-family: "Space Grotesk", Inter, system-ui, sans-serif !important;
    font-size: 20px !important;
    font-weight: 700 !important;
    letter-spacing: -0.04em !important;
    color: #fff !important;
    text-decoration: none !important;
    flex-shrink: 0;
}
.ts-logo span { color: #9c88b5 !important; }

/* Center links */
.ts-links.nav-links {
    display: flex !important;
    align-items: center;
    gap: 8px;
    position: static !important;
    transform: none !important;
}
.ts-links a {
    position: relative;
    padding: 8px 14px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    letter-spacing: 0.02em;
    color: rgba(255,255,255,0.72) !important;
    text-decoration: none !important;
    border-radius: 999px;
    transition: color 0.2s ease, background 0.2s ease;
}
.ts-links a:hover {
    color: #fff !important;
    background: rgba(255,255,255,0.06);
}
.ts-links a.active-page {
    color: #fff !important;
    background: rgba(156, 136, 181, 0.22) !important;
}
.ts-links a.active-page::after {
    display: none !important; /* pill style instead of underline */
}

/* Actions */
.ts-actions.nav-actions {
    display: flex !important;
    align-items: center;
    gap: 4px;
}

.ts-icon-btn,
.ts-cart,
.ts-theme {
    width: 40px;
    height: 40px;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    border: none !important;
    background: transparent !important;
    color: rgba(255,255,255,0.85) !important;
    border-radius: 50% !important;
    cursor: pointer;
    text-decoration: none !important;
    position: relative;
    transition: background 0.2s ease, color 0.2s ease;
}
.ts-icon-btn:hover,
.ts-cart:hover,
.ts-theme:hover {
    background: rgba(255,255,255,0.08) !important;
    color: #fff !important;
}
.ts-icon-btn.active-page,
.ts-cart.active-page {
    color: #c9bdd8 !important;
    background: rgba(156, 136, 181, 0.18) !important;
}
.ts-icon-btn i,
.ts-cart i { font-size: 17px; }

/* Cart badge */
.ts-cart .ts-cart-count,
.ts-cart .cart-count {
    position: absolute !important;
    top: 6px !important;
    right: 4px !important;
    min-width: 16px;
    height: 16px;
    padding: 0 4px;
    border-radius: 999px;
    background: #9c88b5 !important;
    color: #111 !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    line-height: 16px !important;
    text-align: center;
    border: none !important;
}

/* Theme icons */
.ts-theme { position: relative; }
.ts-theme-sun { display: none; }
body.dark-mode .ts-theme-moon { display: none; }
body.dark-mode .ts-theme-sun { display: inline-block; }

/* Burger — 2 lines */
.ts-burger.mobile-menu {
    display: none !important;
    width: 40px;
    height: 40px;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: transparent !important;
    border: none !important;
    padding: 0 !important;
}
.ts-burger span {
    display: block;
    width: 18px;
    height: 1.5px;
    background: #fff;
    border-radius: 2px;
    transition: 0.2s ease;
}
.ts-burger.is-open span:first-child {
    transform: translateY(3.75px) rotate(45deg);
}
.ts-burger.is-open span:last-child {
    transform: translateY(-3.75px) rotate(-45deg);
}

/* Mobile drawer */
.ts-drawer {
    position: fixed;
    inset: 0;
    z-index: 10050;
    background: rgba(0,0,0,0.45);
}
.ts-drawer[hidden] { display: none !important; }
.ts-drawer-panel {
    position: absolute;
    top: 0; right: 0;
    width: min(320px, 88vw);
    height: 100%;
    background: #111;
    color: #fff;
    padding: 24px 22px;
    box-shadow: -20px 0 50px rgba(0,0,0,0.35);
}
.ts-drawer-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 36px;
}
.ts-drawer-links {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.ts-drawer-links a {
    padding: 14px 12px;
    border-radius: 12px;
    color: rgba(255,255,255,0.85);
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
}
.ts-drawer-links a:hover {
    background: rgba(255,255,255,0.06);
    color: #fff;
}

/* Dark mode page body still works; nav stays dark by design */
body.dark-mode .navbar.ts-nav {
    background: rgba(10, 10, 10, 0.94) !important;
}

@media (max-width: 900px) {
    .ts-links.nav-links { display: none !important; }
    .ts-burger.mobile-menu { display: inline-flex !important; }
}
</style>

<script>
(function () {
    var nav = document.getElementById('tsNav');
    var burger = document.getElementById('mobileMenu');
    var drawer = document.getElementById('tsDrawer');
    var closeBtn = document.getElementById('tsDrawerClose');

    function onScroll() {
        if (!nav) return;
        if (window.scrollY > 12) nav.classList.add('is-scrolled');
        else nav.classList.remove('is-scrolled');
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    function openDrawer() {
        if (!drawer || !burger) return;
        drawer.hidden = false;
        burger.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
        if (!drawer || !burger) return;
        drawer.hidden = true;
        burger.classList.remove('is-open');
        document.body.style.overflow = '';
    }
    if (burger) burger.addEventListener('click', function () {
        if (drawer && drawer.hidden) openDrawer(); else closeDrawer();
    });
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (drawer) drawer.addEventListener('click', function (e) {
        if (e.target === drawer) closeDrawer();
    });
})();
</script>
