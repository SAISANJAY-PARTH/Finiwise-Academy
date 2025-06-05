<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "finwise_academy");

if ($conn->connect_error) {
    die("Connection failed.");
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];

// Example dummy query history — you can fetch actual data from another table later
$query_history = [
    "Viewed: Investment Tool",
    "Asked: How to diversify portfolio?",
    "Accessed: Risk Calculator",
];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Client Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Welcome, <?= htmlspecialchars($name) ?> 👋</h2>

<a href="logout.php" class="btn btn-outline-danger float-end mb-3">Logout</a>

<h4>Your Tool Usage & Query History</h4>
<ul class="list-group">
    <?php foreach ($query_history as $item): ?>
        <li class="list-group-item"><?= htmlspecialchars($item) ?></li>
    <?php endforeach; ?>
</ul>

</body>
</html>
