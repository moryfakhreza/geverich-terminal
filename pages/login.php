<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
$db=getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['balance'] = $user['initial_balance'];

        header("Location: index.php");
        exit;
    }

    $error = "Invalid login";
}
?>

<div class="auth-wrapper">

    <div class="auth-box">

        <div class="auth-title">LOGIN</div>

        <?php if (!empty($error)) echo "<p style='color:red;font-size:12px;'>$error</p>"; ?>

        <form method="POST">
            <input class="auth-input" name="username" placeholder="Username" required>
            <input class="auth-input" type="password" name="password" placeholder="Password" required>

            <button class="auth-btn" type="submit">SIGN IN</button>
        </form>

        <div class="auth-link">
            Don't have account? <a href="index.php?page=register">Register</a>
        </div>

    </div>

</div>