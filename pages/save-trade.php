<?php

session_start();

require_once "../includes/auth.php";
requireLogin();

require_once "../includes/services/TradeService.php";


$service = new TradeService();

$service->create($_POST);


header("Location: ../?page=journal&success=1");
exit;
