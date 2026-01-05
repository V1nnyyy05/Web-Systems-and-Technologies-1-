<?php
$host = 'localhost';
$db   = 'dtr_system';
$user = 'root'; // Change if needed
$pass = '';     // Change if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect: " . $e->getMessage());
}
?>