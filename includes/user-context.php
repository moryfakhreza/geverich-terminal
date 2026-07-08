<?php

require_once __DIR__ . '/db.php';

function getUserContext($userId)
{
    $db = getDB();

    // ==========================
    // USER
    // ==========================

    $stmt = $db->prepare("
        SELECT
            username,
            initial_balance
        FROM users
        WHERE id = ?
    ");

    $stmt->execute([$userId]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ==========================
    // OVERVIEW
    // ==========================

    $stmt = $db->prepare("
        SELECT

            COUNT(*) total_trade,

            SUM(CASE WHEN hasil='WIN' THEN 1 ELSE 0 END) total_win,

            IFNULL(SUM(profit_usd),0) total_profit,

            IFNULL(AVG(rr),0) avg_rr,

            IFNULL(SUM(CASE WHEN profit_usd>0 THEN profit_usd ELSE 0 END),0) gross_profit,

            IFNULL(ABS(SUM(CASE WHEN profit_usd<0 THEN profit_usd ELSE 0 END)),0) gross_loss

        FROM trades

        WHERE user_id = ?
    ");

    $stmt->execute([$userId]);

    $stats = $stmt->fetch(PDO::FETCH_ASSOC);

    // ==========================
    // BEST PAIR
    // ==========================

    $stmt = $db->prepare("
        SELECT pair

        FROM trades

        WHERE user_id = ?

        GROUP BY pair

        ORDER BY SUM(profit_usd) DESC

        LIMIT 1
    ");

    $stmt->execute([$userId]);

    $pair = $stmt->fetchColumn();

    // ==========================
    // BEST STRATEGY
    // ==========================

    $stmt = $db->prepare("
        SELECT strategy

        FROM trades

        WHERE user_id = ?
          AND strategy IS NOT NULL
          AND strategy <> ''

        GROUP BY strategy

        ORDER BY SUM(profit_usd) DESC

        LIMIT 1
    ");

    $stmt->execute([$userId]);

    $strategy = $stmt->fetchColumn();

    // ==========================
    // FAVORITE EMOTION
    // ==========================

    $stmt = $db->prepare("
        SELECT emotion

        FROM trades

        WHERE user_id = ?
          AND emotion IS NOT NULL
          AND emotion <> ''

        GROUP BY emotion

        ORDER BY COUNT(*) DESC

        LIMIT 1
    ");

    $stmt->execute([$userId]);

    $emotion = $stmt->fetchColumn();

    // ==========================
    // CALCULATION
    // ==========================

    $totalTrade = (int)$stats['total_trade'];
    $totalWin = (int)$stats['total_win'];

    $winRate = $totalTrade > 0
        ? round(($totalWin / $totalTrade) * 100, 2)
        : 0;

    $profitFactor = 0;

    if ($stats['gross_loss'] > 0) {
        $profitFactor = round(
            $stats['gross_profit'] / $stats['gross_loss'],
            2
        );
    }

    return [

        "username" => $user['username'] ?? "Trader",

        "balance" => $user['initial_balance'] ?? 0,

        "total_trade" => $totalTrade,

        "win_rate" => $winRate,

        "total_profit" => round($stats['total_profit'],2),

        "profit_factor" => $profitFactor,

        "avg_rr" => round($stats['avg_rr'],2),

        "best_pair" => $pair ?: "-",

        "best_strategy" => $strategy ?: "-",

        "favorite_emotion" => $emotion ?: "-"

    ];
}