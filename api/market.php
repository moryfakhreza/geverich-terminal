<?php

require_once "../includes/config.php";

function fetchPrice($symbol) {
    $url = "https://api.twelvedata.com/price?symbol=$symbol&apikey=" . TWELVE_API_KEY;
    $res = @file_get_contents($url);
    $data = json_decode($res, true);

    return isset($data["price"]) ? (float)$data["price"] : 0;
}

function fakeChange() {
    return rand(-30, 30) / 10;
}

$gold = fetchPrice("XAU/USD");
$dxy = fetchPrice("DXY");
$usdjpy = fetchPrice("USD/JPY");
$us10y = fetchPrice("US10Y");

header('Content-Type: application/json');

echo json_encode([
    "gold" => [
        "symbol" => "XAU/USD",
        "price" => $gold,
        "change" => fakeChange()
    ],
    "dxy" => [
        "symbol" => "DXY",
        "price" => $dxy,
        "change" => fakeChange()
    ],
    "usdjpy" => [
        "symbol" => "USD/JPY",
        "price" => $usdjpy,
        "change" => fakeChange()
    ],
    "us10y" => [
        "symbol" => "US10Y",
        "price" => $us10y,
        "change" => fakeChange()
    ],
    "timestamp" => time()
]);