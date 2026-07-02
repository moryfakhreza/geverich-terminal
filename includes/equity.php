<?php

function getUserEquity($db, $user_id)
{
    // ambil initial balance
    $stmt = $db->prepare("
        SELECT initial_balance 
        FROM users 
        WHERE id = ?
    ");
    $stmt->execute([$user_id]);
    $balance = $stmt->fetchColumn();

    if ($balance === false) {
        $balance = 0;
    }

    // ambil total profit
    $stmt = $db->prepare("
        SELECT SUM(profit_usd)
        FROM trades
        WHERE user_id = ?
    ");
    $stmt->execute([$user_id]);
    $profit = $stmt->fetchColumn();

    if ($profit === null) {
        $profit = 0;
    }

    return $balance + $profit;
}
?>

