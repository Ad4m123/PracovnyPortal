<?php
session_start();
require_once "config.php";
require_once "../classes/SavedJob.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['HTTP_REFERER'] ?? '../job-listings.php';
    header("Location: ../login.php");
    exit;
}

// Check if job_id is provided
if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
    header("Location: ../job-listings.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();

$savedJobObj = new SavedJob($db);
$userId = $_SESSION['user_id'];
$jobId = (int)$_GET['job_id'];

// Check if job is already saved
if ($savedJobObj->isJobSaved($userId, $jobId)) {
    $_SESSION['message'] = "Job is already in your liked jobs!";
    $_SESSION['message_type'] = "info";
} else {
    // Save the job
    if ($savedJobObj->saveJob($userId, $jobId)) {
        $_SESSION['message'] = "Job saved to liked jobs successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error saving job.";
        $_SESSION['message_type'] = "error";
    }
}

// Redirect back to the job details page
$redirectUrl = $_SERVER['HTTP_REFERER'] ?? '../job-details.php?id=' . $jobId;
header("Location: " . $redirectUrl);
exit;
?>