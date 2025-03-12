<?php
// Project Showcase & Portfolio (projects/project_showcase.php)
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT p.id, p.title, p.description, p.category, p.status, p.created_at, u.name AS innovator, 
                                     COALESCE(SUM(f.amount), 0) AS total_funding 
                              FROM projects p 
                              JOIN users u ON p.user_id = u.id 
                              LEFT JOIN funding f ON p.id = f.project_id 
                              GROUP BY p.id, u.name 
                              ORDER BY p.created_at DESC");
        
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($projects);
    } catch (PDOException $e) {
        die("Error fetching project showcase: " . $e->getMessage());
    }
}
?>
