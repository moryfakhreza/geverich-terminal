<?php

$db=getDB();

$id=$_GET['id'] ?? 0;

$stmt=$db->prepare("
SELECT *
FROM trades
WHERE id=?
");

$stmt->execute([$id]);

$trade=$stmt->fetch();

if(!$trade){

    die("Trade tidak ditemukan.");

}

?>

<div class="card">

    <div class="panel-title">
        TRADE DETAIL
    </div>

    <div class="panel-content">

        <table class="detail-table">

            <tr>
                <td>Date</td>
                <td><?= $trade['tanggal'] ?></td>
            </tr>

            <tr>
                <td>Pair</td>
                <td><?= $trade['pair'] ?></td>
            </tr>

            <tr>
                <td>Direction</td>
                <td><?= $trade['direction'] ?></td>
            </tr>

            <tr>
                <td>Entry Price</td>
                <td><?= $trade['entry_price'] ?></td>
            </tr>

            <tr>
                <td>Stop Loss</td>
                <td><?= $trade['sl'] ?></td>
            </tr>

            <tr>
                <td>Take Profit</td>
                <td><?= $trade['tp'] ?></td>
            </tr>

            <tr>
                <td>Exit Price</td>
                <td><?= $trade['exit_price'] ?></td>
            </tr>

            <tr>
                <td>Lot</td>
                <td><?= $trade['lot'] ?></td>
            </tr>

            <tr>
                <td>Profit</td>
                <td>$<?= number_format((float)$trade['profit_usd'],2) ?></td>
            </tr>

            <tr>
                <td>Result</td>
                <td><?= $trade['hasil'] ?></td>
            </tr>

            <tr>
                <td>Emotion</td>
                <td><?= $trade['emotion'] ?></td>
            </tr>

            <tr>
                <td>Notes</td>
                <td><?= nl2br(htmlspecialchars($trade['note'])) ?></td>
            </tr>

        </table>

        <br>

        <a href="?page=journal" class="btn btn-primary">
            ← Back
        </a>

    </div>

</div>