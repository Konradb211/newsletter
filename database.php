<?php
$config = require_once 'config.php';

try {
    $conn = new PDO("mysql:host={$config['host']}; dbname={$config['db']}; charset=utf8", $config['user'], $config['password'], [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

} catch (PDOException $e) {
    echo "Connection Failed: ".$e->getMessage();
}