<?php

$db = getDB();

$sql = "

SELECT

COUNT(*) totalTrades,

SUM(CASE WHEN hasil='WIN' THEN 1 ELSE 0 END) wins,

SUM(CASE WHEN hasil='LOSS' THEN 1 ELSE 0 END) losses,

SUM(CASE WHEN profit_usd>0 THEN profit_usd ELSE 0 END) totalProfit,

SUM(CASE WHEN profit_usd<0 THEN ABS(profit_usd) ELSE 0 END) totalLoss,

SUM(profit_usd) netProfit

FROM trades

";

$stats = $db->query($sql)->fetch(PDO::FETCH_ASSOC);

$totalTrades = (int)$stats['totalTrades'];

$wins = (int)$stats['wins'];

$losses = (int)$stats['losses'];

$winRate = $totalTrades
? round($wins/$totalTrades*100,2)
:0;

$totalProfit = $stats['totalProfit'] ?? 0;

$totalLoss = $stats['totalLoss'] ?? 0;

$netProfit = $stats['netProfit'] ?? 0;

$profitFactor = $totalLoss>0
? round($totalProfit/$totalLoss,2)
:0;

$stmt = $db->query("
SELECT
tanggal,
profit_usd
FROM trades
ORDER BY tanggal ASC, id ASC
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$equity = [];

$total = 0;

foreach($rows as $row){

    $total += (float)$row['profit_usd'];

    $labels[] = $row['tanggal'];

    $equity[] = $total;
}
$pairStats = $db->query("

SELECT

pair,

COUNT(*) total_trade,

SUM(CASE WHEN hasil='WIN' THEN 1 ELSE 0 END) win_trade,

SUM(profit_usd) net_profit

FROM trades

GROUP BY pair

ORDER BY net_profit DESC

")->fetchAll(PDO::FETCH_ASSOC);

$emotionStats = $db->query("

SELECT

emotion,

COUNT(*) total_trade,

SUM(CASE WHEN hasil='WIN' THEN 1 ELSE 0 END) win_trade,

SUM(profit_usd) net_profit

FROM trades

WHERE emotion IS NOT NULL
AND emotion <> ''

GROUP BY emotion

ORDER BY net_profit DESC

")->fetchAll(PDO::FETCH_ASSOC);

$bestTrade = $db->query("
SELECT *
FROM trades
ORDER BY profit_usd DESC
LIMIT 1
")->fetch(PDO::FETCH_ASSOC);

$worstTrade = $db->query("
SELECT *
FROM trades
ORDER BY profit_usd ASC
LIMIT 1
")->fetch(PDO::FETCH_ASSOC);

$avgProfit = $db->query("
SELECT AVG(profit_usd) AS avg_profit
FROM trades
")->fetch(PDO::FETCH_ASSOC);

?>

<div class="analytics-grid">

<div class="stat-card">

<div class="stat-title">

WIN RATE

</div>

<div class="stat-value">

<?= $winRate ?>%

</div>

</div>

<div class="stat-card">

<div class="stat-title">

PROFIT FACTOR

</div>

<div class="stat-value">

<?= $profitFactor ?>

</div>

</div>

<div class="stat-card">

<div class="stat-title">

TOTAL PROFIT

</div>

<div class="stat-value profit">

$

<?= number_format($totalProfit,2) ?>

</div>

</div>

<div class="stat-card">

<div class="stat-title">

TOTAL LOSS

</div>

<div class="stat-value loss">

$

<?= number_format($totalLoss,2) ?>

</div>

</div>

<div class="stat-card">

<div class="stat-title">

NET PROFIT

</div>

<div class="stat-value <?= $netProfit>=0?'profit':'loss' ?>">

$

<?= number_format($netProfit,2) ?>

</div>

</div>

<div class="stat-card">

<div class="stat-title">

TOTAL TRADES

</div>

<div class="stat-value">

<?= $totalTrades ?>

</div>

</div>

</div>

<div class="card">

    <div class="panel-title">
        EQUITY CURVE
    </div>

    <div class="panel-content">

       <canvas id="equityChart"height="100"></canvas>

    </div>

</div>

<div class="analytics-bottom">
  
  <div class="card">

    <div class="panel-title">

        PAIR PERFORMANCE

    </div>

    <div class="panel-content">

        <table class="trade-table">

            <thead>

                <tr>

                    <th>Pair</th>

                    <th>Trades</th>

                    <th>Win Rate</th>

                    <th>Net Profit</th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($pairStats as $pair): ?>

            <?php

            $winRatePair = $pair['total_trade'] > 0
                ? ($pair['win_trade'] / $pair['total_trade']) * 100
                : 0;

            ?>

            <tr>

                <td><?= htmlspecialchars($pair['pair']) ?></td>

                <td><?= $pair['total_trade'] ?></td>

                <td><?= number_format($winRatePair,2) ?>%</td>

                <td>

                    <span style="color:<?= $pair['net_profit'] >= 0 ? '#4caf50' : '#ff5252' ?>">

                        $<?= number_format($pair['net_profit'],2) ?>

                    </span>

                </td>

            </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>
  <div class="card">

    <div class="panel-title">

        EMOTION ANALYSIS

    </div>

    <div class="panel-content">

        <table class="trade-table">

            <thead>

                <tr>

                    <th>Emotion</th>

                    <th>Trades</th>

                    <th>Win Rate</th>

                    <th>Profit</th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($emotionStats as $emotion): ?>

            <?php

            $winRateEmotion = $emotion['total_trade'] > 0
                ? ($emotion['win_trade'] / $emotion['total_trade']) * 100
                : 0;

            ?>

            <tr>

                <td><?= htmlspecialchars($emotion['emotion']) ?></td>

                <td><?= $emotion['total_trade'] ?></td>

                <td><?= number_format($winRateEmotion,2) ?>%</td>

                <td>

                    <span style="color:<?= $emotion['net_profit'] >= 0 ? '#4caf50' : '#ff5252' ?>">

                        $<?= number_format($emotion['net_profit'],2) ?>

                    </span>

                </td>

            </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</div>

<div class="mini-widgets">
  <div class="mini-card">

    <div class="mini-title">

        🏆 BEST TRADE

    </div>

    <div class="mini-pair">

        <?= htmlspecialchars($bestTrade['pair']) ?>

    </div>

    <div class="mini-profit profit">

        +$<?= number_format((float)$bestTrade['profit_usd'],2) ?>

    </div>

    <div class="mini-bottom">

        <?= htmlspecialchars($bestTrade['direction']) ?>

    </div>

</div>

<div class="mini-card">

    <div class="mini-title">

        💥 WORST TRADE

    </div>

    <div class="mini-pair">

        <?= htmlspecialchars($worstTrade['pair']) ?>

    </div>

    <div class="mini-profit loss">

        $<?= number_format((float)$worstTrade['profit_usd'],2) ?>

    </div>

    <div class="mini-bottom">

        <?= htmlspecialchars($worstTrade['direction']) ?>

    </div>

</div>

<div class="mini-card">

    <div class="mini-title">

        📈 AVG PROFIT

    </div>

    <div class="mini-profit <?= $avgProfit['avg_profit'] >= 0 ? 'profit' : 'loss' ?>">

        $<?= number_format((float)$avgProfit['avg_profit'],2) ?>

    </div>

    <div class="mini-bottom">

        Per Trade

    </div>

</div>
</div>
<script>

const ctx = document.getElementById("equityChart");

new Chart(ctx,{

    type:"line",

    data:{

        labels:<?= json_encode($labels) ?>,

        datasets:[{

            label:"Equity",

            data:<?= json_encode($equity) ?>,

            borderColor:"#d4af37",

            backgroundColor:"rgba(212,175,55,.15)",

            fill:true,

            tension:.3

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{
                display:false
            }

        }

    }

});

</script>
