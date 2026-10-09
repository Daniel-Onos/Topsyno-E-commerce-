<?php
require_once "shop-data.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Wishlist | TOPSYNO</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="shop-system.css">
<link rel="stylesheet" href="account-pages.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include "header.php"; ?>

<main class="topsyno-wishlist-page">
<section class="wishlist-section">
<div class="wishlist-heading">
<div><p class="section-label">SAVED FOR LATER</p><h1>MY <span>WISHLIST.</span></h1></div>
<a href="shop.php" class="account-outline-button">EXPLORE SHOP</a>
</div>

<div id="wishlistEmpty" class="wishlist-empty" hidden>
<i class="bi bi-heart"></i><h2>YOUR WISHLIST IS EMPTY.</h2>
<p>Save the caps you want to come back to.</p>
<a href="shop.php" class="account-submit">EXPLORE SHOP</a>
</div>

<div id="wishlistGrid" class="wishlist-grid"></div>
</section>
</main>

<script>window.TOPSYNO_PRODUCTS = <?= json_encode(array_values($products), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;</script>
<script src="js/app.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const products = window.TOPSYNO_PRODUCTS || [];
    const key = "topsynoWishlist";
    const grid = document.getElementById("wishlistGrid");
    const empty = document.getElementById("wishlistEmpty");

    const read = () => {
        try { const v = JSON.parse(localStorage.getItem(key)); return Array.isArray(v) ? v.map(String) : []; }
        catch { return []; }
    };
    const esc = s => String(s ?? "").replace(/[&<>"']/g, c => ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"}[c]));

    function render() {
        const ids = read();
        const saved = products.filter(p => ids.includes(String(p.id)));
        grid.innerHTML = "";

        if (!saved.length) { grid.hidden = true; empty.hidden = false; return; }
        grid.hidden = false; empty.hidden = true;

        saved.forEach(p => {
            const card = document.createElement("article");
            card.className = "wishlist-product-card";
            card.innerHTML = `
                <div class="wishlist-product-image">
                    <button type="button" class="wishlist-remove" data-id="${p.id}" aria-label="Remove from wishlist"><i class="bi bi-heart-fill"></i></button>
                    <a href="product.php?id=${encodeURIComponent(p.id)}"><img src="${esc(p.image)}" alt="${esc(p.name)}"></a>
                </div>
                <div class="wishlist-product-info">
                    <p>${esc(String(p.category || "").replaceAll("-", " ").toUpperCase())}</p>
                    <h3>${esc(p.name)}</h3>
                    <strong>₦${Number(p.price || 0).toLocaleString("en-NG")}</strong>
                    <button type="button" class="wishlist-add-cart" data-id="${p.id}" data-name="${esc(p.name)}" data-price="${p.price}" data-image="${esc(p.image)}">
                        ADD TO CART <i class="bi bi-bag-plus"></i>
                    </button>
                </div>`;
            grid.appendChild(card);
        });
    }

    grid.addEventListener("click", e => {
        const remove = e.target.closest(".wishlist-remove");
        if (remove) {
            localStorage.setItem(key, JSON.stringify(read().filter(id => id !== String(remove.dataset.id))));
            if (window.updateWishlistCount) window.updateWishlistCount();
            render();
            return;
        }

        const add = e.target.closest(".wishlist-add-cart");
        if (add) {
            let cart = [];
            try { cart = JSON.parse(localStorage.getItem("topsynoCart")) || []; } catch {}
            const id = String(add.dataset.id);
            const existing = cart.find(x => String(x.id) === id);

            if (existing) existing.quantity = Number(existing.quantity || 1) + 1;
            else cart.push({id, name:add.dataset.name, price:Number(add.dataset.price), image:add.dataset.image, quantity:1});

            localStorage.setItem("topsynoCart", JSON.stringify(cart));
            if (window.updateCartCount) window.updateCartCount();
            add.innerHTML = 'ADDED <i class="bi bi-check2"></i>';
            setTimeout(() => add.innerHTML = 'ADD TO CART <i class="bi bi-bag-plus"></i>', 1200);
        }
    });

    render();
});
</script>
<?php include "footer.php"; ?>
</body>
</html>