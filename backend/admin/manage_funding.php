<?php
// Admin - Manage Funding (admin/manage_funding.php)
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Unauthorized access. Admins only.");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT f.id, f.project_id, p.title, f.investor_id, u.name AS investor, f.amount, f.funded_at FROM funding f 
                              JOIN projects p ON f.project_id = p.id 
                              JOIN users u ON f.investor_id = u.id 
                              ORDER BY f.funded_at DESC");
        
        $funding_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($funding_data);
    } catch (PDOException $e) {
        die("Error fetching funding data: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $funding_id = $_POST['funding_id'];
    $action = $_POST['action']; // 'approve', 'reject', 'delete'
    
    try {
        if ($action === 'approve') {
            $stmt = $pdo->prepare("UPDATE funding SET status = 'approved' WHERE id = ?");
        } elseif ($action === 'reject') {
            $stmt = $pdo->prepare("UPDATE funding SET status = 'rejected' WHERE id = ?");
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM funding WHERE id = ?");
        } else {
            die("Invalid action.");
        }
        
        $stmt->execute([$funding_id]);
        echo "Action performed successfully.";
    } catch (PDOException $e) {
        die("Action failed: " . $e->getMessage());
    }
}
?>
