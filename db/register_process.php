<?php
require_once "db/config.php";

$first_name = $last_name = $email = $password = $confirm_password = "";
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = trim($_POST['first-name']);
    $last_name = trim($_POST['last-name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];


    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long";
    } else {
        $database = new Database();
        $db = $database->getConnection();

        $check_query = "SELECT id FROM user WHERE email = :email";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':email', $email);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $error_message = "Email already exists";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO user (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";

            $insert_stmt = $db->prepare($insert_query);

            $insert_stmt->bindParam(':first_name', $first_name);
            $insert_stmt->bindParam(':last_name', $last_name);
            $insert_stmt->bindParam(':email', $email);
            $insert_stmt->bindParam(':password', $hashed_password);


            if ($insert_stmt->execute()) {
                $success_message = "Registration successful! You can now <a href='login.php'>login</a>";
                $first_name = $last_name = $email = $password = $confirm_password = "";
            } else {
                $error_message = "Something went wrong. Please try again later.";
            }
        }
    }
}