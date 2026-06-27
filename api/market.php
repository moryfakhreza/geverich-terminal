<?php

header("Content-Type: application/json");

$data = [

    "gold"=>[
        "symbol"=>"XAU/USD",
        "price"=>"3352.45",
        "change"=>0.37
    ],

    "dxy"=>[
        "symbol"=>"DXY",
        "price"=>"97.23",
        "change"=>-0.12
    ],

    "us10y"=>[
        "symbol"=>"US10Y",
        "price"=>"4.32%",
        "change"=>0.05
    ],

    "usdjpy"=>[
        "symbol"=>"USD/JPY",
        "price"=>"146.23",
        "change"=>-0.18
    ],

    "news"=>[
        "impact"=>"HIGH IMPACT",
        "title"=>"US Non-Farm Payrolls",
        "time"=>"20:30 WIB"
    ]

];

echo json_encode($data);