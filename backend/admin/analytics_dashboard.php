<?php
// Analytics Dashboard (admin/analytics_dashboard.php)
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Unauthorized access. Admins only.");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Total number of users
        $stmt = $pdo->query("SELECT COUNT(*) AS total_users FROM users");
        $total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
        
        // Total number of projects
        $stmt = $pdo->query("SELECT COUNT(*) AS total_projects FROM projects");
        $total_projects = $stmt->fetch(PDO::FETCH_ASSOC)['total_projects'];
        
        // Total funding amount
        $stmt = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_funding FROM funding");
        $total_funding = $stmt->fetch(PDO::FETCH_ASSOC)['total_funding'];
        
        // Project status breakdown
        $stmt = $pdo->query("SELECT status, COUNT(*) AS count FROM projects GROUP BY status");
        $project_status = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $analytics = [
            'total_users' => $total_users,
            'total_projects' => $total_projects,
            'total_funding' => $total_funding,
            'project_status' => $project_status
        ];
        
        header('Content-Type: application/json');
        echo json_encode($analytics);
    } catch (PDOException $e) {
        die("Error fetching analytics data: " . $e->getMessage());
    }
}
?>
