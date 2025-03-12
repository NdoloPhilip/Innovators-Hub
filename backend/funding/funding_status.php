<?php
// Get Funding Status (funding/funding_status.php)
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->prepare("SELECT f.id, f.amount, f.funded_at, p.title AS project, u.name AS investor 
                              FROM funding f 
                              JOIN projects p ON f.project_id = p.id 
                              JOIN users u ON f.investor_id = u.id 
                              WHERE p.user_id = ? OR f.investor_id = ? 
                              ORDER BY f.funded_at DESC");
        $stmt->execute([$user_id, $user_id]);
        
        $funding = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($funding);
    } catch (PDOException $e) {
        die("Error fetching funding status: " . $e->getMessage());
    }
}
?>
