<?php
// Get Users (auth/get_users.php)
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT id, name, email, role FROM users ORDER BY name ASC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($users);
    } catch (PDOException $e) {
        die("Error fetching users: " . $e->getMessage());
    }
}
?>
