<?php

require_once __DIR__ . '/../user-context.php';

class ContextBuilder
{
    public static function build(int $userId = 0): string
    {
        $user = getUserContext($userId);

        if (!$user) {
            return "";
        }

        return <<<EOT
CURRENT USER

Username : {$user['username']}

Balance : {$user['balance']} USD

Trading Statistics

- Total Trade : {$user['total_trade']}
- Win Rate : {$user['win_rate']} %
- Total Profit : {$user['total_profit']} USD
- Profit Factor : {$user['profit_factor']}
- Average RR : {$user['avg_rr']}
- Best Pair : {$user['best_pair']}
- Best Strategy : {$user['best_strategy']}
- Favorite Emotion : {$user['favorite_emotion']}

INSTRUCTION

- Use this information ONLY when it is relevant.
- Never invent statistics.
- If the user asks about their trading performance, use these statistics.
- If the user asks unrelated questions, ignore this context.
EOT;
    }
}