<?php require_once 'includes/header.php';
$db = getDB();

$today = date('Y-m-d');

$stmt = $db->prepare("
SELECT
COUNT(*) total,
SUM(CASE WHEN hasil='WIN' THEN 1 ELSE 0 END) wins,
SUM(CASE WHEN hasil='LOSS' THEN 1 ELSE 0 END) losses,
COALESCE(SUM(profit_usd),0) pnl
FROM trades
WHERE DATE(tanggal)=?
");

$stmt->execute([$today]);

$stats = $stmt->fetch(PDO::FETCH_ASSOC);

$totalTrades = $stats['total'] ?? 0;
$wins = $stats['wins'] ?? 0;
$pnl = $stats['pnl'] ?? 0;

$winRate = $totalTrades
? round(($wins/$totalTrades)*100)
:0;
?>


<header class="topbar">

    <div class="logo">
        GEVERICH TERMINAL
    </div>

    <div class="topbar-right">

        <div id="todayDate"></div>

        <div id="clock"></div>

    </div>

</header>

<nav class="navbar">
    <a href="#">Dashboard</a>
    <a href="#">Journal</a>
    <a href="#">Analytics</a>
    <a href="#">Calculator</a>
</nav>
<section class="market-ticker">

<div class="tradingview-widget-container">

<div class="tradingview-widget-container__widget"></div>

<script type="text/javascript"
src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js"
async>
{
  "symbols": [
    {
      "proName": "OANDA:XAUUSD",
      "title": "Gold"
    },
    {
      "proName": "OANDA:XAGUSD",
      "title": "Silver"
    },
    {
      "proName": "CAPITALCOM:DXY",
      "title": "Dollar Index"
    },
    {
      "proName": "FX_IDC:USDJPY",
      "title": "USD/JPY"
    },
    {
      "proName": "TVC:USOIL",
      "title": "WTI Oil"
    }
  ],
  "showSymbolLogo": true,
  "isTransparent": true,
  "displayMode": "adaptive",
  "colorTheme": "dark",
  "locale": "en"
}
</script>

</div>

</section>

<section class="stats-grid">

<div class="dashboard-stats">

    <div class="stat-card">

        <div class="stat-title">
            Balance
        </div>

        <div class="stat-value">
            $1,000
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">
            P/L Today
        </div>

        <div class="stat-value <?= $pnl>=0?'profit':'loss' ?>">

            <?= $pnl>=0?'+':'' ?>$<?= number_format($pnl,2) ?>

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">
            Win Rate
        </div>

        <div class="stat-value">

            <?= $winRate ?>%

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">
            Trades
        </div>

        <div class="stat-value">

            <?= $totalTrades ?>/3

        </div>

    </div>

</div>

</section>

<main class="dashboard">

    <section class="chart-card">

        <div class="panel-title">
            LIVE CHART
        </div>

<div class="panel-content chart-body">

    <div id="tv_chart"></div>

</div>

    </section>

    <aside class="sidebar">

        <section class="card">
            <div class="panel-title">Sessions</div>
            <div class="panel-content">Sessions</div>
        </section>

        <section class="card">
            <div class="panel-title">Risk Calculator</div>
            <div class="panel-content">Calculator</div>
        </section>

        <section class="card">
            <div class="panel-title">Checklist</div>
            <div class="panel-content">Checklist</div>
        </section>

    </aside>

</main>

<section class="journal card">
    <div class="panel-title">Journal Preview</div>
    <div class="panel-content">Trade Journal</div>
</section>

<section class="analytics card">
    <div class="panel-title">Analytics</div>
    <div class="panel-content">Analytics</div>
</section>

<footer class="statusbar">
    Ready
</footer>

<?php require_once 'includes/footer.php'; ?>