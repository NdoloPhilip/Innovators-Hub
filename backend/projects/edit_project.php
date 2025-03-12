<?php
// Edit Project (projects/edit_project.php)
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $project_id = $_POST['project_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);

    try {
        // Ensure the user owns the project before editing
        $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, category = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $description, $category, $project_id, $user_id]);
        
        if ($stmt->rowCount() > 0) {
            echo "Project updated successfully.";
        } else {
            echo "No changes made or unauthorized access.";
        }
    } catch (PDOException $e) {
        die("Project update failed: " . $e->getMessage());
    }
}
?>
