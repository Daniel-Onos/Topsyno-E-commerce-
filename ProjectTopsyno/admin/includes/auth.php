<?php
// Protect admin pages

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}