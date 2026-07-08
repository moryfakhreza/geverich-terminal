<?php

require_once __DIR__ . '/../db.php';

class ChatRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function latest(int $userId, int $limit = 50): array
    {
        $stmt = $this->db->prepare("
            SELECT
                role,
                message,
                created_at
            FROM chat_history
            WHERE user_id = ?
            ORDER BY id DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);

        $stmt->execute();

        return array_reverse(
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}
