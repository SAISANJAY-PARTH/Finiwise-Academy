<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');
    $code = trim($_POST["code"] ?? '');

    if (empty($email) || empty($code)) {
        echo "Email and Code are required.";
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "user_auth");
    if ($conn->connect_error) {
        die("DB Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, name FROM users WHERE email = ? AND code = ?");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $email;
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];

        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p style='color:red;'>Invalid email or code.</p>";
        echo "<a href='login.html'>Back to Login</a>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method. Please use the login form.";
    echo "<br><a href='login.html'>Go to Login</a>";
}
?>
