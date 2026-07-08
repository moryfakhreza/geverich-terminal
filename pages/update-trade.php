<?php

require_once "../includes/services/TradeService.php";

$service = new TradeService();

$service->update($_POST);

header("Location: ../index.php?page=journal&success=1");
exit;