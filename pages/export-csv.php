<?php

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

$db = getDB();

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="trade-journal-' . date('Y-m-d') . '.csv"');

$output = fopen('php://output', 'w');

// Header kolom
fputcsv(

$output,

[

'Tanggal',

'Pair',

'Direction',

'Entry',

'SL',

'TP',

'Exit',

'Lot',

'Profit USD',

'Result',

'Emotion',

'Note'

],

",",

"\"",

"\\"

);

$stmt = $db->query("
SELECT
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
FROM trades
ORDER BY tanggal DESC,id DESC
");

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    fputcsv($output,$row,",","\"", "\\");

}

fclose($output);

exit;