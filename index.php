<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

$page = $_GET['page'] ?? 'dashboard';

// =========================
// PUBLIC PAGES (NO LOGIN REQUIRED)
// =========================

$publicPages = ['login', 'register'];

if (!in_array($page, $publicPages)) {
    if (!isLoggedIn()) {
        header("Location: index.php?page=login");
        exit;
    }
}
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once 'includes/market-ticker.php';



// =========================
// ROUTER
// =========================

switch ($page) {

    case 'journal':
        require 'pages/journal.php';
        break;

    case 'journal-create':
        require 'pages/journal-create.php';
        break;

    case 'trade-view':
        require 'pages/trade-view.php';
        break;

    case 'trade-edit':
        require 'pages/trade-edit.php';
        break;

    case 'analytics':
        require 'pages/analytics.php';
        break;

    case 'calculator':
        require 'pages/calculator.php';
        break;

    case 'calendar':
        require 'pages/calendar.php';
        break;

    case 'export-csv':
        require 'pages/export-csv.php';
        break;

    case 'news':
        require 'pages/news.php';
        break;

    case 'heatmap':
        require "pages/heatmap.php";
        break;

    case 'login':
        require 'pages/login.php';
        break;

    case 'register':
        require 'pages/register.php';
        break;

    case 'logout':
        require 'pages/logout.php';
        break;

    default:
        require 'pages/dashboard.php';
        break;
}

require_once 'includes/footer.php';