<?php
// Delete Project (projects/delete_project.php)
session_start();
include '/config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $project_id = $_POST['project_id'];

    try {
        // Ensure the user owns the project before deleting
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
        $stmt->execute([$project_id, $user_id]);
        
        if ($stmt->rowCount() > 0) {
            echo "Project deleted successfully.";
        } else {
            echo "Unauthorized action or project not found.";
        }
    } catch (PDOException $e) {
        die("Project deletion failed: " . $e->getMessage());
    }
}
?>
