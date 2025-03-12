<?php
// Invest in a Project (funding/invest.php)
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $investor_id = $_SESSION['user_id'];
    $project_id = $_POST['project_id'];
    $amount = $_POST['amount'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO funding (investor_id, project_id, amount, funded_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$investor_id, $project_id, $amount]);
        echo "Investment successful.";
    } catch (PDOException $e) {
        die("Investment failed: " . $e->getMessage());
    }
}
?>
