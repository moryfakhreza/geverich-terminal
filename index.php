<?php require_once 'includes/header.php'; ?>

<header class="topbar">
    <div class="logo">GEVERICH TERMINAL</div>
    <div id="clock">00:00 WIB</div>
</header>

<nav class="navbar">
    <a href="#">Dashboard</a>
    <a href="#">Journal</a>
    <a href="#">Analytics</a>
    <a href="#">Calculator</a>
</nav>

<section class="ticker">
    Live Market Ticker
</section>

<section class="stats">
    Statistics
</section>

<main class="dashboard">

    <section class="chart-card">

        <div class="panel-title">
            LIVE CHART
        </div>

        <div class="panel-content">
            Chart Area
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