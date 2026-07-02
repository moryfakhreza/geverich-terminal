<?php
require_once '../includes/auth.php';

if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/auth.php';
}

session_unset();
session_destroy();

header("Location: index.php?page=login");
exit;
?>