<div class="dashboard-layout">

    <!-- LEFT -->
    <div class="dashboard-left">

        <section class="chart-card">

            <div class="panel-title">
                LIVE CHART
            </div>
            <div class="chart-body">
                <div id="tv_chart"></div>
            </div>

        </section>

        <section class="card journal-preview">

            <div class="panel-title">
                RECENT TRADES
            </div>

    <div class="panel-content">

        <?php
        require_once 'includes/auth.php';
        requireLogin();

        $db = getDB();

        $userId = $_SESSION['user_id'];

        $stmt = $db->prepare("
    SELECT *
    FROM trades
    WHERE user_id = ?
    ORDER BY id DESC
    LIMIT 5
");

        $stmt->execute([$userId]);

        $trades = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>

        <table class="trade-table">

            <thead>

                <tr>

                    <th>Date</th>

                    <th>Pair</th>

                    <th>Dir</th>

                    <th>Profit</th>

                    <th>Result</th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($trades as $trade): ?>

            <tr>

                <td><?= $trade['tanggal'] ?></td>

                <td><?= $trade['pair'] ?></td>

<td>

<?php if($trade['direction']=="BUY"): ?>

<span class="badge badge-buy">

🟢 BUY

</span>

<?php else: ?>

<span class="badge badge-sell">

🔴 SELL

</span>

<?php endif; ?>

</td>

 <td>

<?php

$profit=(float)$trade['profit_usd'];

?>

<span style="color:<?= $profit>=0 ? '#4caf50' : '#ff5252' ?>">

$<?= number_format($profit,2) ?>

</span>

</td>

                <td><?= $trade['hasil'] ?></td>

            </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

        <br>

        <a href="?page=journal" class="btn btn-primary">

            View Full Journal →

        </a>

    </div>

</section>

    </div>

    <!-- RIGHT -->
    <aside class="sidebar">

        <?php require __DIR__.'/sessions.php'; ?>
        <?php require __DIR__.'/risk-calculator.php'; ?>
    </aside>

</div>