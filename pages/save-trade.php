<?php

require_once "../includes/config.php";
require_once "../includes/db.php";

$db = getDB();

$sql = "INSERT INTO trades
(
    tanggal,
    pair,
    direction,
    entry_price,
    sl,
    tp,
    exit_price,
    lot,
    profit_usd,
    hasil,
    emotion,
    note
)
VALUES
(
    :tanggal,
    :pair,
    :direction,
    :entry_price,
    :sl,
    :tp,
    :exit_price,
    :lot,
    :profit_usd,
    :hasil,
    :emotion,
    :note
)";

$stmt = $db->prepare($sql);

$stmt->execute([

    ":tanggal" => $_POST["tanggal"],

    ":pair" => $_POST["pair"],

    ":direction" => $_POST["direction"],

":entry_price" => $_POST["entry_price"] !== "" ? $_POST["entry_price"] : null,

":sl" => $_POST["sl"] !== "" ? $_POST["sl"] : null,

":tp" => $_POST["tp"] !== "" ? $_POST["tp"] : null,

":exit_price" => $_POST["exit_price"] !== "" ? $_POST["exit_price"] : null,

":lot" => $_POST["lot"] !== "" ? $_POST["lot"] : null,

":profit_usd" => $_POST["profit_usd"] !== "" ? $_POST["profit_usd"] : 0,

    ":hasil" => $_POST["hasil"],

    ":emotion" => $_POST["emotion"],

    ":note" => $_POST["note"]

]);

header("Location: ../?page=journal&success=1");
exit;