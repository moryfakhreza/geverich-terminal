<?php

require_once "../includes/config.php";
require_once "../includes/db.php";

$db = getDB();

$stmt = $db->prepare("
UPDATE trades SET

tanggal=?,
pair=?,
direction=?,
entry_price=?,
sl=?,
tp=?,
exit_price=?,
lot=?,
profit_usd=?,
hasil=?,
emotion=?,
note=?

WHERE id=?
");

$stmt->execute([

$_POST['tanggal'],
$_POST['pair'],
$_POST['direction'],
$_POST['entry_price'],
$_POST['sl'],
$_POST['tp'],
$_POST['exit_price'],
$_POST['lot'],
$_POST['profit_usd'],
$_POST['hasil'],
$_POST['emotion'],
$_POST['note'],
$_POST['id']

]);

header("Location: ../index.php?page=journal");
exit;