<?php

$mode = "create";

$trade = [
    'user_id' => $_SESSION['user_id'],

    "tanggal" => date("Y-m-d"),

    "pair" => "XAU/USD",

    "direction" => "BUY",

    "entry_price" => "",

    "sl" => "",

    "tp" => "",

    "exit_price" => "",

    "lot" => "",

    "profit_usd" => "",

    "hasil" => "WIN",

    "emotion" => "Confident",

    "note" => ""

];

require "components/trade-form.php";
?>