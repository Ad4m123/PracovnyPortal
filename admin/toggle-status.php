<?php
session_start();
require_once "../db/config.php";
require_once "../classes/AdminJob.php";

// Kontrola admin oprávnení
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}

// Kontrola parametrov
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['action'])) {
    $_SESSION['message'] = "Neplatné parametre";
    $_SESSION['message_type'] = "error";
    header("Location: ../edit-jobs.php");
    exit;
}

$jobId = (int)$_GET['id'];
$action = $_GET['action'];

// Validácia akcie
if (!in_array($action, ['activate', 'deactivate'])) {
    $_SESSION['message'] = "Neplatná akcia";
    $_SESSION['message_type'] = "error";
    header("Location: ../edit-jobs.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$adminJobObj = new AdminJob($db);

// Skontrolovať či ponuka existuje
$job = $adminJobObj->getJobByIdAdmin($jobId);
if (!$job) {
    $_SESSION['message'] = "Pracovná ponuka nebola nájdená";
    $_SESSION['message_type'] = "error";
    header("Location: ../edit-jobs.php");
    exit;
}

// Vykonať akciu
$success = false;
$messageText = "";

if ($action == 'activate') {
    $success = $adminJobObj->activateJob($jobId);
    $messageText = $success ?
        "Pracovná ponuka '" . htmlspecialchars($job['title']) . "' bola aktivovaná" :
        "Chyba pri aktivácii pracovnej ponuky";
} else {
    $success = $adminJobObj->deactivateJob($jobId);
    $messageText = $success ?
        "Pracovná ponuka '" . htmlspecialchars($job['title']) . "' bola deaktivovaná" :
        "Chyba pri deaktivácii pracovnej ponuky";
}

// Nastaviť správu a presmerovať
$_SESSION['message'] = $messageText;
$_SESSION['message_type'] = $success ? "success" : "error";

header("Location: ../edit-jobs.php");
exit;
?>