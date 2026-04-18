<?php
$host = 'localhost';
$db   = 'exam_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
     $pdo = new PDO($dsn, $user, $pass);
     echo "SUCCESS: Connected to $db";
} catch (\PDOException $e) {
     echo "FAILURE: " . $e->getMessage();
}
