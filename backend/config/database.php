<?php
// Database configuration file (config/database.php)

$host = 'localhost'; // Change if using a remote server
$dbname = 'innovators_hub';
$user = 'username';
$password = 'password';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
