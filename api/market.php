<?php

header("Content-Type: application/json");

require_once "../providers/DummyProvider.php";

$provider = new DummyProvider();

echo json_encode($provider->getMarketData()); ?>

        <section class="card journal-preview">

    <div class="panel-title">

        RECENT TRADES

    </div>

    <div class="panel-content">

        <?php

        $db = getDB();

        $trades = $db->query("
        SELECT *
        FROM trades
        ORDER BY id DESC
        LIMIT 5
        ")->fetchAll();

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