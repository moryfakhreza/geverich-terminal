<?php

require_once "../includes/config.php";
require_once "../includes/db.php";

$db = getDB();

$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("DELETE FROM trades WHERE id=?");

$stmt->execute([$id]);

header("Location: ../index.php?page=journal");
exit;