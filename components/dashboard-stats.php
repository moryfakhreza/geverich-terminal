<?php

require_once 'includes/auth.php';
requireLogin();

$db = getDB();

$userId = $_SESSION['user_id'];
$today = date('Y-m-d');

$stmt = $db->prepare("
SELECT
    COUNT(*) total,
    SUM(CASE WHEN hasil='WIN' THEN 1 ELSE 0 END) wins,
    SUM(CASE WHEN hasil='LOSS' THEN 1 ELSE 0 END) losses,
    SUM(CASE WHEN hasil='BE' THEN 1 ELSE 0 END) bes,
    COALESCE(SUM(profit_usd),0) pnl
FROM trades
WHERE user_id = ?
AND DATE(tanggal) = ?
");

$stmt->execute([
    $userId,
    $today
]);

$stats = $stmt->fetch(PDO::FETCH_ASSOC);

$totalTrades = $stats['total'] ?? 0;
$wins = $stats['wins'] ?? 0;
$losses = $stats['losses'] ?? 0;
$bes = $stats['bes'] ?? 0;
$pnl = $stats['pnl'] ?? 0;

$winRate = $totalTrades > 0
    ? round(($wins / $totalTrades) * 100)
    : 0;
?>

<div class="dashboard-stats">

    <div class="stat-card">
        <div class="stat-title">Today's P/L</div>
        <div class="stat-value <?= $pnl >= 0 ? 'profit' : 'loss' ?>">
            <?= $pnl >= 0 ? '+' : '' ?>$<?= number_format($pnl, 2) ?>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Trades</div>
        <div class="stat-value">
            <?= $totalTrades ?>/3
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Win Rate</div>
        <div class="stat-value">
            <?= $winRate ?>%
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-title">W / L / BE</div>
        <div class="stat-value">
            <?= $wins ?>/<?= $losses ?>/<?= $bes ?>
        </div>
    </div>

</div>