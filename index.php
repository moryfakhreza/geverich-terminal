<?php require_once 'includes/header.php'; ?>

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
<section class="ticker">

    <div class="ticker-track" id="marketTicker">

        Loading Market...

    </div>

</section>


<section class="stats-grid">

    <div class="stat-card">
        <div class="stat-title">P&L Today</div>
        <div class="stat-value profit">+$0.00</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Trades</div>
        <div class="stat-value">0 / 3</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Win Rate</div>
        <div class="stat-value">0%</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Balance</div>
        <div class="stat-value">$0.00</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Average RR</div>
        <div class="stat-value">1 : 0</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Daily Target</div>
        <div class="stat-value">0%</div>
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