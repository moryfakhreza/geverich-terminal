<?php

require_once __DIR__ . '/ai/AIService.php';
require_once __DIR__ . '/auth.php';
requireLogin();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function askAI(string $prompt): string
{
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        return "ERROR: user_id kosong di session";
    }

    $ai = new AIService();

    $result = $ai->chat($userId, $prompt);

    if (!$result) {
        return "ERROR: AIService return kosong";
    }

    return $result;
}