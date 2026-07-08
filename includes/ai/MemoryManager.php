<?php

require_once __DIR__ . '/../chat-memory.php';

class MemoryManager
{
    /**
     * Ambil histori chat
     */
    public static function history(int $userId, int $limit = 5): array
    {
        return getChatHistory($userId, $limit);
    }

    /**
     * Simpan chat
     */
    public static function save(int $userId, string $role, string $message): void
    {
        saveChat($userId, $role, $message);
    }
}