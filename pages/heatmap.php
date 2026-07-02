<?php

$db = getDB();

$trades = $db->query("
    SELECT profit_usd, tanggal
    FROM trades
")->fetchAll();

/* =========================
   DAILY MAP
========================= */

$dayMap = [
    "Mon" => 0,
    "Tue" => 0,
    "Wed" => 0,
    "Thu" => 0,
    "Fri" => 0,
    "Sat" => 0,
    "Sun" => 0,
];

$totalProfit = 0;

foreach ($trades as $t) {

    $profit = (float)$t['profit_usd'];
    $totalProfit += $profit;

    $day = date("D", strtotime($t['tanggal']));

    if (isset($dayMap[$day])) {
        $dayMap[$day] += $profit;
    }
}

/* =========================
   BEST / WORST
========================= */

$bestDay = array_keys($dayMap, max($dayMap))[0];
$worstDay = array_keys($dayMap, min($dayMap))[0];

/* =========================
   DUAL SCALE (POSITIVE / NEGATIVE)
========================= */

$maxProfit = 1;
$maxLoss = 1;

foreach ($dayMap as $val) {

    if ($val > 0 && $val > $maxProfit) {
        $maxProfit = $val;
    }

    if ($val < 0 && abs($val) > $maxLoss) {
        $maxLoss = abs($val);
    }
}

?>

<!-- =========================
     HEATMAP CONTAINER
========================= -->

<div class="heatmap-container">

    <!-- HEADER -->
    <div class="heat-header">
        <h2>TRADE PERFORMANCE</h2>
        <p>Dual direction profit/loss analysis</p>
    </div>

    <!-- SUMMARY -->
    <div class="heat-summary">

        <div class="card">
            <div class="label">TOTAL P/L</div>
            <div class="value"><?= number_format($totalProfit, 2) ?> USD</div>
        </div>

        <div class="card">
            <div class="label">BEST DAY</div>
            <div class="value"><?= $bestDay ?></div>
        </div>

        <div class="card">
            <div class="label">WORST DAY</div>
            <div class="value"><?= $worstDay ?></div>
        </div>

    </div>

    <!-- DUAL HEATMAP -->
    <div class="day-grid">

        <?php foreach ($dayMap as $day => $val): ?>

            <?php
            if ($val >= 0) {
                $percent = ($val / $maxProfit) * 100;
            } else {
                $percent = (abs($val) / $maxLoss) * 100;
            }
            ?>

            <div class="day-box">

                <div class="day-name"><?= $day ?></div>

                <!-- DUAL BAR -->
                <div class="dual-bar">

                    <!-- NEGATIVE SIDE -->
                    <div class="bar negative">
                        <?php if ($val < 0): ?>
                            <div class="fill red"
                                style="width: <?= $percent ?>%">
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- CENTER LINE -->
                    <div class="center-line"></div>

                    <!-- POSITIVE SIDE -->
                    <div class="bar positive">
                        <?php if ($val > 0): ?>
                            <div class="fill gold"
                                style="width: <?= $percent ?>%">
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="day-value">
                    <?= number_format($val, 2) ?>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>