<?php
// Edit Profile (user/edit_profile.php)
session_start();
include '/config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    
    try {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $email, $user_id]);
        
        echo "Profile updated successfully.";
    } catch (PDOException $e) {
        die("Profile update failed: " . $e->getMessage());
    }
}
?>