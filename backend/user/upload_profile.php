<?php
// Upload Profile Picture (user/upload_profile.php)
session_start();
include '/config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $user_id = $_SESSION['user_id'];
    $upload_dir = '../uploads/profile_pictures/';
    $file_name = basename($_FILES['profile_picture']['name']);
    $target_file = $upload_dir . $user_id . "_" . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check file type
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
    }
    
    // Move uploaded file
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->execute([$target_file, $user_id]);
            echo "Profile picture uploaded successfully.";
        } catch (PDOException $e) {
            die("Profile picture upload failed: " . $e->getMessage());
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
