<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "Invalid request method.";
    exit;
}

if (empty($_POST['email'])) {
    echo "Email is required.";
    exit;
}

$email = $_POST['email'];

// Connect to your database
$conn = new mysqli("localhost", "root", "", "user_auth");
if ($conn->connect_error) {
    echo "Database connection failed.";
    exit;
}

// Fetch code for email
$stmt = $conn->prepare("SELECT code FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($code);
if ($stmt->fetch()) {
    echo "Code: " . htmlspecialchars($code);
} else {
    echo "Email not found.";
}

$stmt->close();
$conn->close();
?>
