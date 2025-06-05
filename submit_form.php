<?php
// Suppress PHP error output
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Log errors
ini_set('log_errors', 1);
ini_set('error_log', 'C:\xampp\htdocs\portfolio - Copy\php_errors.log');

// Set JSON content type
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$dbname = 'user_auth';
$username = 'root';
$password = '';

try {
    $mysqli = new mysqli($host, $username, $password, $dbname);
    if ($mysqli->connect_error) {
        throw new Exception('Database connection failed: ' . $mysqli->connect_error);
    }
    error_log('Database connected successfully');
} catch (Exception $e) {
    error_log('Database connection error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$full_name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone_number = $_POST['phone_number'] ?? null;

// Validate inputs
if (empty($full_name) || empty($email)) {
    error_log('Validation failed: Missing full_name or email');
    echo json_encode(['success' => false, 'message' => 'Full name and email are required']);
    exit;
}

// Generate 6-character code
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*';
$code = '';
for ($i = 0; $i < 6; $i++) {
    $code .= $characters[rand(0, strlen($characters) - 1)];
}

// Insert into contact_submissions
try {
    $stmt = $mysqli->prepare("INSERT INTO contact_submissions (full_name, email, phone_number, code) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $phone_number, $code);
    $stmt->execute();
    error_log('Contact submission saved: ' . $email);
    echo json_encode(['success' => true, 'code' => $code]);
    $stmt->close();
} catch (Exception $e) {
    error_log('Database error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error saving submission']);
    exit;
}

$mysqli->close();
?>