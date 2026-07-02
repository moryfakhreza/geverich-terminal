<?php

$db = new PDO('sqlite:database/geverich.db');

$stmt = $db->prepare("
    UPDATE trades 
    SET user_id = 1 
    WHERE user_id IS NULL
");

$stmt->execute();

echo "DONE MIGRATION USER ID";
