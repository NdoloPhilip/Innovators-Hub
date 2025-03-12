<?php
// Get Projects (projects/get_projects.php)
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT p.id, p.title, p.description, p.category, p.status, p.created_at, u.name AS innovator FROM projects p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($projects);
    } catch (PDOException $e) {
        die("Error fetching projects: " . $e->getMessage());
    }
}
?>
