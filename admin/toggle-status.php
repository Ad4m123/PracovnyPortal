<?php
session_start();
require_once "../db/config.php";
require_once "../classes/AdminJob.php";

$database = new Database();
$db = $database->getConnection();
$adminJobObj = new AdminJob($db);


$adminJobObj->checkAdminPermission();

$adminJobObj->processToggleRequest('Job', '../edit-jobs.php');
?>