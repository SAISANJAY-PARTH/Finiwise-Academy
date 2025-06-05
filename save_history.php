<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Database connection (update with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_auth";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]);
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

$calculator = $data['calculator'] ?? '';
$input = json_encode($data['input'] ?? []);
$output = $data['output'] ?? '';

if (empty($calculator) || empty($input) || empty($output)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit();
}

try {
    $stmt = $conn->prepare("INSERT INTO calculator_history (user_id, calculator, input, output) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $calculator, $input, $output]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}