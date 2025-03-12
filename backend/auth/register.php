<?php
// User Registration (auth/register.php)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $activation_code = md5(uniqid(rand(), true));
    $is_active = false;

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role, activation_code, is_active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role, $activation_code, $is_active]);
        
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com';
        $mail->Password = 'your-app-password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->setFrom('your-email@gmail.com', 'Innovators Hub');
        $mail->addAddress($email);
        $mail->Subject = "Account Activation - Innovators Hub";
        $mail->Body = "Click to activate your account: http://localhost/backend/auth/activate.php?code=$activation_code";
        
        $mail->send();
        echo "Registration successful. Check your email to activate your account.";
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
