<?php

require_once __DIR__ . '/db.php';

function saveChat($userId, $role, $message)
{
    $db = getDB();

    $stmt = $db->prepare("
        INSERT INTO chat_history(user_id, role, message)
        VALUES(?,?,?)
    ");

    $stmt->execute([
        $userId,
        $role,
        $message
    ]);
}

function getChatHistory($userId, $limit = 10)
{
    $db = getDB();

    $stmt = $db->prepare("
        SELECT role, message
        FROM chat_history
        WHERE user_id = ?
        ORDER BY id DESC
        LIMIT ?
    ");

    $stmt->bindValue(1, $userId, PDO::PARAM_INT);
    $stmt->bindValue(2, $limit, PDO::PARAM_INT);

    $stmt->execute();

    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // balik agar urutan lama -> baru
    return array_reverse($history);
}