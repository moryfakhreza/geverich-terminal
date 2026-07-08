<?php

$db = getDB();

$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("
SELECT *
FROM trades
WHERE id = ?
");

$stmt->execute([$id]);

$trade = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$trade) {
    die("Trade tidak ditemukan.");
}

$profitClass = $trade['profit_usd'] >= 0 ? "profit" : "loss";
$resultColor = match ($trade['hasil']) {
    "WIN" => "#27ae60",
    "LOSS" => "#e74c3c",
    default => "#f1c40f"
};
?>

<div class="card">

    <div class="panel-title">
        TRADE DETAIL
    </div>

    <div class="panel-content">

        <h3>GENERAL</h3>

        <table class="detail-table">

            <tr>
                <td>Date</td>
                <td><?= htmlspecialchars($trade['tanggal']) ?></td>
            </tr>

            <tr>
                <td>Pair</td>
                <td><?= htmlspecialchars($trade['pair']) ?></td>
            </tr>

            <tr>
                <td>Direction</td>
                <td><?= htmlspecialchars($trade['direction']) ?></td>
            </tr>

        </table>

        <hr>

        <h3>PRICE</h3>

        <table class="detail-table">

            <tr>
                <td>Entry</td>
                <td><?= $trade['entry_price'] ?></td>
            </tr>

            <tr>
                <td>Exit</td>
                <td><?= $trade['exit_price'] ?></td>
            </tr>

            <tr>
                <td>Stop Loss</td>
                <td><?= $trade['sl'] ?></td>
            </tr>

            <tr>
                <td>Take Profit</td>
                <td><?= $trade['tp'] ?></td>
            </tr>

        </table>

        <hr>

        <h3>PERFORMANCE</h3>

        <table class="detail-table">

            <tr>
                <td>Lot</td>
                <td><?= $trade['lot'] ?></td>
            </tr>

            <tr>
                <td>Risk Reward</td>
                <td><?= number_format((float)$trade['rr'],2) ?> R</td>
            </tr>

            <tr>
                <td>Profit</td>
                <td class="<?= $profitClass ?>">
                    $<?= number_format((float)$trade['profit_usd'],2) ?>
                </td>
            </tr>

            <tr>
                <td>Result</td>
                <td style="color:<?= $resultColor ?>;font-weight:bold;">
                    <?= htmlspecialchars($trade['hasil']) ?>
                </td>
            </tr>

        </table>

        <hr>

        <h3>PSYCHOLOGY</h3>

        <table class="detail-table">

            <tr>
                <td>Emotion</td>
                <td><?= htmlspecialchars($trade['emotion']) ?></td>
            </tr>

            <tr>
                <td>Strategy</td>
                <td><?= htmlspecialchars($trade['strategy'] ?? '-') ?></td>
            </tr>

        </table>

        <hr>

        <h3>NOTES</h3>

        <div class="terminal-output">

            <?= nl2br(htmlspecialchars($trade['note'])) ?>

        </div>

        <hr>

        <h3>AI REVIEW</h3>

        <div class="terminal-output">

            GT&gt; AI Review akan tersedia pada update berikutnya.

        </div>

        <br>

        <a href="?page=journal" class="btn btn-primary">
            ← Back to Journal
        </a>

    </div>

</div>