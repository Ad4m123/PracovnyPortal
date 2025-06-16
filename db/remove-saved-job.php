<?php
session_start();
require_once "config.php";
require_once "../classes/SavedJob.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Check if job_id is provided
if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
    header("Location: ../liked-jobs.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();

$savedJobObj = new SavedJob($db);
$userId = $_SESSION['user_id'];
$jobId = (int)$_GET['job_id'];

// Remove the saved job
if ($savedJobObj->removeSavedJob($userId, $jobId)) {
    $_SESSION['message'] = "Job removed from liked jobs successfully!";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Error removing job from liked jobs.";
    $_SESSION['message_type'] = "error";
}

header("Location: ../liked-jobs.php");
exit;
?>