<?php
// Get Messages (collaboration/get_messages.php)
session_start();
include '/config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->prepare("SELECT m.id, m.message, m.sent_at, u.name AS sender 
                              FROM messages m 
                              JOIN users u ON m.sender_id = u.id 
                              WHERE m.receiver_id = ? OR m.sender_id = ? 
                              ORDER BY m.sent_at DESC");
        $stmt->execute([$user_id, $user_id]);
        
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($messages);
    } catch (PDOException $e) {
        die("Error fetching messages: " . $e->getMessage());
    }
}
?>
