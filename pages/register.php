<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $balance  = $_POST['balance'];

    $stmt = $db->prepare("
        INSERT INTO users (username, password, initial_balance)
        VALUES (?, ?, ?)
    ");

    try {
        $stmt->execute([$username, $password, $balance]);
        header("Location: index.php?page=login");
        exit;
    } catch (Exception $e) {
        $error = "Username already exists";
    }
}
?>
<link rel="stylesheet" href="assets/css/style.css">
<div class="auth-wrapper">

    <div class="auth-box">

        <div class="auth-title">REGISTER</div>

        <?php if (!empty($error)) echo "<p style='color:red;font-size:12px;'>$error</p>"; ?>

        <form method="POST">
            <input class="auth-input" name="username" placeholder="Username" required>
            <input class="auth-input" type="password" name="password" placeholder="Password" required>
            <input class="auth-input" type="number" name="balance" placeholder="Initial Balance" required>

            <button class="auth-btn" type="submit">CREATE ACCOUNT</button>
        </form>

        <div class="auth-link">
            Already have account? <a href="index.php?page=login">Login</a>
        </div>

    </div>

</div>