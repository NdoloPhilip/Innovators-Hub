<?php
// Session Check (auth/session_check.php)
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    echo json_encode(["logged_in" => true, "name" => $_SESSION['user_name'], "role" => $_SESSION['user_role']]);
} else {
    echo json_encode(["logged_in" => false]);
}
?>
