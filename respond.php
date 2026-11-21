<?php
require "config.php";
require_login();

$me = (int)$_SESSION['student_id'];
$id = (int)$_POST['id'];
$status = ($_POST['action'] == "accept") ? "accepted" : "declined";

// Only the student who RECEIVED the request can answer it
$conn->query("UPDATE requests SET status='$status' WHERE id=$id AND to_id=$me AND status='pending'");
header("Location: requests.php");
exit;
