<?php
require_once __DIR__ . '/config/db.php';
$db = getDB();
$sql = file_get_contents(__DIR__ . '/database/schema.sql');
try {
    $db->exec($sql);
    echo "Success!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
