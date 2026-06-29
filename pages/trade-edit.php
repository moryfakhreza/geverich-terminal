<?php

$db = getDB();

$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("
SELECT *
FROM trades
WHERE id=?
");

$stmt->execute([$id]);

$trade = $stmt->fetch();

if(!$trade){

    die("Trade tidak ditemukan");

}

$mode = "edit";

require "components/trade-form.php";
?>