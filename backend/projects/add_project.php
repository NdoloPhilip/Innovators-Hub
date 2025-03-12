<?php
// Add Project (projects/add_project.php)
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $status = 'pending'; // Default status

    try {
        $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description, category, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $title, $description, $category, $status]);
        echo "Project submitted successfully. Awaiting approval.";
    } catch (PDOException $e) {
        die("Project submission failed: " . $e->getMessage());
    }
}
?>
