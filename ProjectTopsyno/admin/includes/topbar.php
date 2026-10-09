<header class="topbar">
    <div class="topbar-left">
        <h2><?= $pageTitle ?? 'Dashboard' ?></h2>
    </div>
    <div class="topbar-right">
        <span>Hello, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
    </div>
</header>