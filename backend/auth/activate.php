<?php
// Account Activation (auth/activate.php)
include '/config/database.php';

if (isset($_GET['code'])) {
    $activation_code = $_GET['code'];
    try {
        $stmt = $pdo->prepare("UPDATE users SET is_active = TRUE WHERE activation_code = ?");
        $stmt->execute([$activation_code]);
        if ($stmt->rowCount() > 0) {
            echo "Account activated successfully. You can now <a href='../../frontend/pages/login.html'>login</a>.";
        } else {
            echo "Invalid or expired activation code.";
        }
    } catch (PDOException $e) {
        die("Activation failed: " . $e->getMessage());
    }
} else {
    echo "No activation code provided.";
}
?>
