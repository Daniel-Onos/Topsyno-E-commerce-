<?php
session_start();
require_once "database.php";

if (!empty($_SESSION["user_id"])) {
    header("Location: account.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Please enter a valid email address.";
    if ($password === "") $errors[] = "Please enter your password.";

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];

            $redirect = $_GET["redirect"] ?? "account.php";
            if (!preg_match('/^[a-zA-Z0-9_\-\/?.=&]+$/', $redirect)) $redirect = "account.php";
            header("Location: " . $redirect);
            exit;
        }

        $errors[] = "Email or password is incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | TOPSYNO</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="shop-system.css">
<link rel="stylesheet" href="account-pages.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include "header.php"; ?>

<main class="topsyno-account-page">
<section class="account-auth-card">
<p class="section-label">WELCOME BACK</p>
<h1>LOG <span>IN.</span></h1>
<p class="account-lead">Sign in to access your TOPSYNO account.</p>

<?php if ($errors): ?>
<div class="account-message error">
<?php foreach ($errors as $error): ?><p><?= htmlspecialchars($error) ?></p><?php endforeach; ?>
</div>
<?php endif; ?>

<form method="POST" class="account-form">
<label>EMAIL ADDRESS<input type="email" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required></label>
<label>PASSWORD<input type="password" name="password" required></label>
<button class="account-submit" type="submit">LOGIN <i class="bi bi-arrow-right"></i></button>
</form>

<p class="account-switch">Don't have an account? <a href="register.php">CREATE ACCOUNT</a></p>
</section>
</main>

<?php include "footer.php"; ?>
</body>
</html>