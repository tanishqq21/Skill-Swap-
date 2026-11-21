<?php
require "config.php";
require_login();

$me = (int)$_SESSION['student_id'];
$to = isset($_POST['to_id']) ? (int)$_POST['to_id'] : 0;

// Only send if it is another student and there is no request yet
if ($to > 0 && $to != $me && !request_between($conn, $me, $to)) {
    $conn->query("INSERT INTO requests (from_id, to_id, status) VALUES ($me, $to, 'pending')");
}
header("Location: students.php");
exit;
