<?php
// Send Message (collaboration/send_message.php)
session_start();
include '/config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = trim($_POST['message']);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message, sent_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$sender_id, $receiver_id, $message]);
        echo "Message sent successfully.";
    } catch (PDOException $e) {
        die("Message sending failed: " . $e->getMessage());
    }
}
?>
