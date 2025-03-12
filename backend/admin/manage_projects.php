<?php
// Admin - Manage Projects (admin/manage_projects.php)
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Unauthorized access. Admins only.");
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    $action = $_POST['action']; // 'approve', 'reject', 'delete'
    
    try {
        if ($action === 'approve') {
            $stmt = $pdo->prepare("UPDATE projects SET status = 'approved' WHERE id = ?");
        } elseif ($action === 'reject') {
            $stmt = $pdo->prepare("UPDATE projects SET status = 'rejected' WHERE id = ?");
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        } else {
            die("Invalid action.");
        }
        
        $stmt->execute([$project_id]);
        echo "Action performed successfully.";
    } catch (PDOException $e) {
        die("Action failed: " . $e->getMessage());
    }
}
?>
