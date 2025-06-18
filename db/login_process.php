<?php
session_start();
require_once "config.php";
require_once "classes/AuthValidator.php";
require_once "classes/AuthenticationHandler.php";

$email = $password = "";
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $database = new Database();
    $db = $database->getConnection();

    $authHandler = new AuthenticationHandler($db);
    $result = $authHandler->handleLogin($email, $password);

    if ($result['success']) {
        $success_message = $result['message'];
        if ($result['redirect']) {
            header("Location: " . $result['redirect']);
            exit;
        }
    } else {
        $error_message = $result['message'];
        if ($result['redirect']) {
            header("Location: " . $result['redirect']);
            exit;
        }
    }
}
?>