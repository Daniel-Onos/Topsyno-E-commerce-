<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function requireLogin(): void {
    if (empty($_SESSION["user_id"])) {
        header("Location: login.php?redirect=" . urlencode($_SERVER["REQUEST_URI"] ?? "account.php"));
        exit;
    }
}
?>