<?php
$host = 'localhost';
$db   = 'enrollment';
$user = 'root';
$pass = ''; // Leave empty for XAMPP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
     $conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (\PDOException $e) {
     die("Connection failed: " . $e->getMessage());
}