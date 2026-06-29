<?php

$mode = "create";

$trade = [

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