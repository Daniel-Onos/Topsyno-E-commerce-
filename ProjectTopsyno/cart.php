<?php
$pageTitle = "Cart | TOPSYNO";
include 'header.php';
?>

<main class="cart-page-main">
    <section class="cart-hero">
        <p class="shop-eyebrow">YOUR BAG</p>
        <h1>Shopping cart</h1>
    </section>

    <section class="cart-layout">
        <div class="cart-list" id="cartList">
            <div class="cart-loading">Loading cart…</div>
        </div>

        <aside class="cart-summary">
            <h2>Order summary</h2>
            <div class="cart-row"><span>Subtotal</span><strong id="cartSubtotal">₦0</strong></div>
            <div class="cart-row muted"><span>Shipping</span><span>Calculated at checkout</span></div>
            <div class="cart-row total"><span>Total</span><strong id="cartTotal">₦0</strong></div>
            <button type="button" class="cart-checkout-btn" id="checkoutBtn">Proceed to checkout</button>
            <a href="shop.php" class="cart-continue">Continue shopping</a>
            <p class="cart-note">Items are saved on this device. Stock is confirmed when you place the order.</p>
        </aside>
    </section>
</main>

<style>
.cart-page-main { background: #f5f1ea; min-height: 70vh; padding-bottom: 80px; }
.cart-hero {
    padding: calc(var(--announcement-height, 30px) + var(--navbar-height, 72px) + 40px) 6% 28px;
    background: #171717; color: #fff;
}
.cart-hero h1 {
    font-family: "Space Grotesk", Inter, sans-serif;
    font-size: clamp(34px, 5vw, 56px);
    letter-spacing: -0.05em; margin: 8px 0 0;
}
.shop-eyebrow { font-size: 11px; letter-spacing: 0.18em; font-weight: 700; color: #9c88b5; }
.cart-layout {
    display: grid;
    grid-template-columns: 1.4fr 0.8fr;
    gap: 28px;
    padding: 32px 6% 0;
}
.cart-list, .cart-summary {
    background: #fff; border: 1px solid #e8e2d9; border-radius: 14px; padding: 22px;
}
.cart-summary h2 { font-size: 16px; margin-bottom: 18px; }
.cart-row { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 12px; font-size: 14px; }
.cart-row.muted { color: #8a8279; font-size: 13px; }
.cart-row.total { border-top: 1px solid #eee; padding-top: 14px; margin-top: 8px; font-size: 16px; }
.cart-checkout-btn {
    width: 100%; margin-top: 16px; padding: 14px; border: none; border-radius: 8px;
    background: #171717; color: #fff; font-weight: 700; font-size: 13px; letter-spacing: .05em; cursor: pointer;
}
.cart-checkout-btn:hover { background: #9c88b5; color: #171717; }
.cart-continue { display: block; text-align: center; margin-top: 14px; font-size: 13px; color: #6b6560; text-decoration: none; }
.cart-note { margin-top: 18px; font-size: 12px; color: #9a938a; line-height: 1.5; }
.cart-item {
    display: grid; grid-template-columns: 88px 1fr auto; gap: 16px;
    padding: 16px 0; border-bottom: 1px solid #f0ebe3; align-items: center;
}
.cart-item:last-child { border-bottom: none; }
.cart-item img { width: 88px; height: 88px; object-fit: cover; border-radius: 10px; background: #eee6dc; }
.cart-item h3 { font-size: 15px; margin: 0 0 6px; }
.cart-item .meta { font-size: 13px; color: #8a8279; }
.cart-qty { display: flex; align-items: center; gap: 8px; margin-top: 10px; }
.cart-qty button {
    width: 28px; height: 28px; border: 1px solid #ded8cf; background: #fff; border-radius: 6px; cursor: pointer;
}
.cart-item-price { font-weight: 700; font-size: 15px; text-align: right; }
.cart-remove { display: block; margin-top: 8px; font-size: 12px; color: #b91c1c; background: none; border: none; cursor: pointer; }
.cart-empty { text-align: center; padding: 48px 12px; color: #8a8279; }
@media (max-width: 900px) {
    .cart-layout { grid-template-columns: 1fr; }
    .cart-item { grid-template-columns: 72px 1fr; }
    .cart-item-price { grid-column: 2; text-align: left; }
}
</style>

<script>
(function () {
    const KEY = 'capturedCart';
    const list = document.getElementById('cartList');
    const subtotalEl = document.getElementById('cartSubtotal');
    const totalEl = document.getElementById('cartTotal');
    const checkoutBtn = document.getElementById('checkoutBtn');

    function getCart() {
        try { return JSON.parse(localStorage.getItem(KEY)) || []; }
        catch (e) { return []; }
    }
    function saveCart(cart) {
        localStorage.setItem(KEY, JSON.stringify(cart));
        const badge = document.getElementById('cartCount');
        if (badge) {
            const n = cart.reduce((s, i) => s + (i.quantity || 1), 0);
            badge.textContent = n;
        }
    }
    function money(n) {
        return '₦' + Number(n || 0).toLocaleString('en-NG', { maximumFractionDigits: 0 });
    }
    function render() {
        const cart = getCart();
        if (!cart.length) {
            list.innerHTML = '<div class="cart-empty"><h2>Your cart is empty</h2><p>Browse the shop and add a few caps.</p><p style="margin-top:16px"><a href="shop.php">Shop now</a></p></div>';
            subtotalEl.textContent = money(0);
            totalEl.textContent = money(0);
            return;
        }
        let subtotal = 0;
        list.innerHTML = cart.map((item, index) => {
            const qty = item.quantity || 1;
            const line = (item.price || 0) * qty;
            subtotal += line;
            return `
            <div class="cart-item" data-index="${index}">
                <img src="${item.image || 'images/placeholder.png'}" alt="" onerror="this.src='images/placeholder.png'">
                <div>
                    <h3>${item.name || 'Product'}</h3>
                    <div class="meta">${money(item.price)} each</div>
                    <div class="cart-qty">
                        <button type="button" data-action="dec" data-index="${index}">−</button>
                        <span>${qty}</span>
                        <button type="button" data-action="inc" data-index="${index}">+</button>
                    </div>
                    <button type="button" class="cart-remove" data-action="remove" data-index="${index}">Remove</button>
                </div>
                <div class="cart-item-price">${money(line)}</div>
            </div>`;
        }).join('');
        subtotalEl.textContent = money(subtotal);
        totalEl.textContent = money(subtotal);
    }

    list.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;
        const index = Number(btn.dataset.index);
        const cart = getCart();
        if (!cart[index]) return;
        if (btn.dataset.action === 'inc') cart[index].quantity = (cart[index].quantity || 1) + 1;
        if (btn.dataset.action === 'dec') cart[index].quantity = Math.max(1, (cart[index].quantity || 1) - 1);
        if (btn.dataset.action === 'remove') cart.splice(index, 1);
        saveCart(cart);
        render();
    });

    checkoutBtn.addEventListener('click', function () {
        const cart = getCart();
        if (!cart.length) { alert('Your cart is empty.'); return; }
        alert('Checkout can be connected to orders next. Your cart total is ready.');
    });

    render();
})();
</script>

<?php include 'footer.php'; ?>