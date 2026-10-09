<?php
session_start();
require_once "database.php";

if (!empty($_SESSION["user_id"])) {
    header("Location: account.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    if ($name === "") $errors[] = "Please enter your name.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Please enter a valid email address.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";

    if (!$errors) {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->fetch()) {
            $errors[] = "An account with that email already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hash]);

            session_regenerate_id(true);
            $_SESSION["user_id"] = $pdo->lastInsertId();
            $_SESSION["user_name"] = $name;
            $_SESSION["user_email"] = $email;

            header("Location: account.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account | TOPSYNO</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="shop-system.css">
<link rel="stylesheet" href="account-pages.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include "header.php"; ?>

<main class="topsyno-account-page">
<section class="account-auth-card">
<p class="section-label">JOIN TOPSYNO</p>
<h1>CREATE <span>ACCOUNT.</span></h1>
<p class="account-lead">Create your account to manage orders, your wishlist and your details.</p>

<?php if ($errors): ?>
<div class="account-message error">
<?php foreach ($errors as $error): ?><p><?= htmlspecialchars($error) ?></p><?php endforeach; ?>
</div>
<?php endif; ?>

<form method="POST" class="account-form">
<label>FULL NAME<input type="text" name="name" value="<?= htmlspecialchars($_POST["name"] ?? "") ?>" required></label>
<label>EMAIL ADDRESS<input type="email" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required></label>
<label>PASSWORD<input type="password" name="password" required></label>
<label>CONFIRM PASSWORD<input type="password" name="confirm_password" required></label>
<button class="account-submit" type="submit">CREATE ACCOUNT <i class="bi bi-arrow-right"></i></button>
</form>

<p class="account-switch">Already have an account? <a href="login.php">LOGIN</a></p>
</section>
</main>

<?php include "footer.php"; ?>
</body>
</html>