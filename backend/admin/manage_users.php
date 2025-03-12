<?php
// Admin - Manage Users (admin/manage_users.php)
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Unauthorized access. Admins only.");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT id, name, email, role, is_active FROM users ORDER BY role");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($users);
    } catch (PDOException $e) {
        die("Error fetching users: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $action = $_POST['action']; // 'activate', 'deactivate', 'delete', 'change_role'
    $new_role = $_POST['role'] ?? '';
    
    try {
        if ($action === 'activate') {
            $stmt = $pdo->prepare("UPDATE users SET is_active = TRUE WHERE id = ?");
        } elseif ($action === 'deactivate') {
            $stmt = $pdo->prepare("UPDATE users SET is_active = FALSE WHERE id = ?");
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        } elseif ($action === 'change_role' && in_array($new_role, ['innovator', 'investor', 'admin'])) {
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$new_role, $user_id]);
            echo "User role updated successfully.";
            exit;
        } else {
            die("Invalid action.");
        }
        
        $stmt->execute([$user_id]);
        echo "Action performed successfully.";
    } catch (PDOException $e) {
        die("Action failed: " . $e->getMessage());
    }
}
?>
