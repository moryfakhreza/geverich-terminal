<?php

require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once 'includes/market-ticker.php';

$page = $_GET['page'] ?? 'dashboard';

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

    default:
        require 'pages/dashboard.php';
        break;
}

require_once 'includes/footer.php';

