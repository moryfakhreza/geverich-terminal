<?php

header("Content-Type: application/json");

require_once "../providers/DummyProvider.php";

$provider = new DummyProvider();

echo json_encode($provider->getMarketData());