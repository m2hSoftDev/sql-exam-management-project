<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS exam_db");
    echo "SUCCESS: Database 'exam_db' ensured.";
} catch (PDOException $e) {
    echo "FAILURE: " . $e->getMessage();
}
