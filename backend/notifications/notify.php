<?php
// Notifications & Activity Tracking (notifications/notify.php)
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id']; // Recipient user ID
    $message = trim($_POST['message']);

    if (empty($message)) {
        die("Notification message cannot be empty.");
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$user_id, $message]);
        
        echo "Notification sent successfully.";
    } catch (PDOException $e) {
        die("Notification failed: " . $e->getMessage());
    }
}
?>
