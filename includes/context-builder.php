<?php

require_once __DIR__ . '/user-context.php';
require_once __DIR__ . '/chat-memory.php';

function buildContext($userId)
{
    $user = getUserContext($userId);

    $history = getChatHistory($userId, 10);

    $text = "";

    /*
    ==========================
    USER PROFILE
    ==========================
    */

    $text .= "CURRENT USER\n";

    $text .= "Username : {$user['username']}\n";

    $text .= "Balance : {$user['balance']} USD\n";

    $text .= "Total Trade : {$user['total_trade']}\n";

    $text .= "Win Rate : {$user['win_rate']} %\n";

    $text .= "Total Profit : {$user['total_profit']} USD\n\n";

    /*
    ==========================
    CHAT HISTORY
    ==========================
    */

    if (!empty($history)) {

        $text .= "RECENT CONVERSATION\n";

        foreach ($history as $chat) {

            $role = strtoupper($chat['role']);

            $text .= "{$role}: {$chat['message']}\n";

        }

        $text .= "\n";

    }

    return $text;
}