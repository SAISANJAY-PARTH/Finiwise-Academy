<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "finwise_academy");

$stmt = $conn->prepare("INSERT INTO user_activity (user_id, activity) VALUES (?, ?)");
$tool = "Used SIP Calculator";
$stmt->bind_param("is", $_SESSION['user_id'], $tool);
$stmt->execute();
?>
