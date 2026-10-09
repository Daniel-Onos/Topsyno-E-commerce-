<?php
$current = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar">
    <div class="sidebar-logo">
        TOPSYNO<span>.</span>
    </div>

    <nav class="sidebar-nav">
        <a href="index.php" class="<?= $current === 'index.php' ? 'active' : '' ?>">
            Dashboard
        </a>
        <a href="products.php" class="<?= $current === 'products.php' ? 'active' : '' ?>">
            Products
        </a>
        <a href="orders.php" class="<?= $current === 'orders.php' ? 'active' : '' ?>">
            Orders
        </a>
        <a href="customers.php" class="<?= $current === 'customers.php' ? 'active' : '' ?>">
            Customers
        </a>
      
       <a href="transactions.php" class="<?= $current === 'transactions.php' ? 'active' : '' ?>">Transactions</a>
<a href="bank-details.php" class="<?= $current === 'bank-details.php' ? 'active' : '' ?>">Bank Details</a>
    </nav>

    <div class="sidebar-footer">
        <a href="logout.php">Logout</a>
    </div>
</aside>