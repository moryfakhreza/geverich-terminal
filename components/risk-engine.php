<?php

$db = getDB();
// =========================
// RISK ENGINE CORE
// =========================

$balance = 1000;
$maxDailyLoss = 100;
$maxTrades = 8;
$riskPerTradePercent = 2;

// =========================
// DATA TODAY
// =========================

$todayTrades = $db->query("
    SELECT profit_usd 
    FROM trades 
    WHERE DATE(tanggal) = DATE('now')
")->fetchAll();

$totalPnL = 0;
$totalTrades = count($todayTrades);

foreach ($todayTrades as $t) {
    $totalPnL += (float)$t['profit_usd'];
}

// =========================
// CALCULATION
// =========================

$drawdown = min(0, $totalPnL);
$drawdownPercent = ($drawdown / $balance) * 100;

$riskPerTrade = ($balance * $riskPerTradePercent) / 100;

// =========================
// STATUS ENGINE
// =========================

$status = "SAFE";
$statusClass = "safe";

if ($drawdown <= -$maxDailyLoss) {
    $status = "STOP TRADING (DAILY LOSS HIT)";
    $statusClass = "danger";
} elseif ($totalTrades >= $maxTrades) {
    $status = "STOP TRADING (OVERTRADE)";
    $statusClass = "danger";
} elseif ($drawdown < - ($maxDailyLoss * 0.7)) {
    $status = "WARNING (NEAR LIMIT)";
    $statusClass = "warning";
}
?>

<div class="risk-container">

    <div class="risk-title">
        ⚠ RISK ENGINE
    </div>

    <div class="risk-grid">

        <div class="risk-box">
            <div class="label">Balance</div>
            <div class="value"><?= $balance ?> USD</div>
        </div>

        <div class="risk-box">
            <div class="label">Today P/L</div>
            <div class="value"><?= number_format($totalPnL, 2) ?> USD</div>
        </div>

        <div class="risk-box">
            <div class="label">Trades</div>
            <div class="value"><?= $totalTrades ?> / <?= $maxTrades ?></div>
        </div>

        <div class="risk-box">
            <div class="label">Risk/Trade</div>
            <div class="value"><?= $riskPerTrade ?> USD</div>
        </div>

    </div>

    <div class="risk-status <?= $statusClass ?>">
        <?= $status ?>
    </div>

    <div class="risk-bar">
        <div class="fill"
            style="width: <?= min(100, abs($drawdownPercent)) ?>%"></div>
    </div>

</div>