<?php
require_once "config.php";
require_once "classes/AuthValidator.php";
require_once "classes/AuthenticationHandler.php";

$first_name = $last_name = $email = $password = $confirm_password = "";
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    $authHandler = new AuthenticationHandler($db);

    $first_name = $authHandler->sanitizeInput($_POST['first-name']);
    $last_name = $authHandler->sanitizeInput($_POST['last-name']);
    $email = $authHandler->sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    $result = $authHandler->handleRegistration($first_name, $last_name, $email, $password, $confirm_password);

    if ($result['success']) {
        $success_message = $result['message'];
        if ($result['clearForm']) {
            $first_name = $last_name = $email = $password = $confirm_password = "";
        }
    } else {
        $error_message = $result['message'];
    }
}
?>