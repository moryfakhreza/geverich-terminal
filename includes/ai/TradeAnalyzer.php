<?php

require_once __DIR__ . '/../db.php';

class TradeAnalyzer
{
    private PDO $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function analyze(int $userId): array
{
    $stmt = $this->db->prepare("
        SELECT hasil
        FROM trades
        WHERE user_id = ?
        ORDER BY tanggal DESC, id DESC
    ");

    $stmt->execute([$userId]);

    $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // ==========================
// Average Statistics
// ==========================

$stmt = $this->db->prepare("
SELECT

AVG(rr) avg_rr,

AVG(
CASE
WHEN profit_usd > 0
THEN profit_usd
END
) avg_profit,

AVG(
CASE
WHEN profit_usd < 0
THEN ABS(profit_usd)
END
) avg_loss

FROM trades

WHERE user_id = ?
");

$stmt->execute([$userId]);

$avg = $stmt->fetch(PDO::FETCH_ASSOC);

// ==========================
// Favorite Pair
// ==========================

$stmt = $this->db->prepare("
SELECT pair
FROM trades
WHERE user_id = ?
GROUP BY pair
ORDER BY COUNT(*) DESC
LIMIT 1
");

$stmt->execute([$userId]);

$favoritePair = $stmt->fetchColumn() ?: "-";


// ==========================
// Favorite Strategy
// ==========================

$stmt = $this->db->prepare("
SELECT strategy
FROM trades
WHERE user_id = ?
AND strategy IS NOT NULL
AND strategy <> ''
GROUP BY strategy
ORDER BY COUNT(*) DESC
LIMIT 1
");

$stmt->execute([$userId]);


$favoriteStrategy = $stmt->fetchColumn() ?: "-";


// ==========================
// Favorite Emotion
// ==========================

$stmt = $this->db->prepare("
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

$favoriteEmotion = $stmt->fetchColumn() ?: "-";

    $lastResult = "-";
    $winningStreak = 0;
    $losingStreak = 0;

    if (!empty($results)) {

        $lastResult = $results[0];

        if ($lastResult === "WIN") {

            foreach ($results as $result) {

                if ($result === "WIN") {
                    $winningStreak++;
                } else {
                    break;
                }

            }

        } elseif ($lastResult === "LOSS") {

            foreach ($results as $result) {

                if ($result === "LOSS") {
                    $losingStreak++;
                } else {
                    break;
                }

            }

        }

    }

    return [

        "last_result" => $lastResult,

        "winning_streak" => $winningStreak,

        "losing_streak" => $losingStreak,

       "average_rr" => round((float)$avg["avg_rr"], 2),

"average_profit" => round((float)$avg["avg_profit"], 2),

"average_loss" => round((float)$avg["avg_loss"], 2),

"favorite_pair" => $favoritePair,

"favorite_strategy" => $favoriteStrategy,

"favorite_emotion" => $favoriteEmotion

    ];
}
}