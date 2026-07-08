<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . "/TradeAnalyzer.php";

class TradeContextBuilder
{
    public static function build(int $userId, int $limit = 10): string
    {
        $db = getDB();
        $analyzer = new TradeAnalyzer();

$summary = $analyzer->analyze($userId);

        $stmt = $db->prepare("
            SELECT
                tanggal,
                pair,
                direction,
                hasil,
                profit_usd,
                rr,
                strategy,
                emotion,
                note
            FROM trades
            WHERE user_id = ?
            ORDER BY tanggal DESC, id DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);

        $stmt->execute();

        $trades = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($trades)) {
            return "RECENT TRADES\nNo trading history available.";
        }

        $text = "RECENT TRADES\n\n";
        $text = <<<TXT
TRADE SUMMARY

Last Result : {$summary['last_result']}

Winning Streak : {$summary['winning_streak']}

Losing Streak : {$summary['losing_streak']}

Average RR : {$summary['average_rr']}

Average Profit : {$summary['average_profit']} USD

Average Loss : {$summary['average_loss']} USD

Favorite Pair : {$summary['favorite_pair']}

Favorite Strategy : {$summary['favorite_strategy']}

Favorite Emotion : {$summary['favorite_emotion']}

======================================

RECENT TRADES

TXT;

        $i = 1;

        foreach ($trades as $trade) {

            $text .= "Trade {$i}\n";
            $text .= "Date : {$trade['tanggal']}\n";
            $text .= "Pair : {$trade['pair']}\n";
            $text .= "Direction : {$trade['direction']}\n";
            $text .= "Result : {$trade['hasil']}\n";
            $text .= "Profit : {$trade['profit_usd']} USD\n";
            $text .= "RR : {$trade['rr']}\n";
            $text .= "Strategy : {$trade['strategy']}\n";
            $text .= "Emotion : {$trade['emotion']}\n";

            if (!empty($trade['note'])) {
                $text .= "Note : {$trade['note']}\n";
            }

            $text .= "\n-------------------------\n\n";

            $i++;
        }

        return $text;
    }
}