<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $mobile = $_POST["mobile"];
    $email = $_POST["email"];

    $code = rand(100000, 999999);

    $conn = new mysqli("localhost", "root", "", "user_auth");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO users (name, mobile, email, code)
                            VALUES (?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE name=?, mobile=?, code=?");
    $stmt->bind_param("sssssss", $name, $mobile, $email, $code, $name, $mobile, $code);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo '
    <html>
    <head>
      <title>Signup Success</title>
      <style>
        body {
          background: #f4f7f8;
          font-family: Arial, sans-serif;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
        }
        .message-box {
          background: #fff;
          padding: 30px 40px;
          border-radius: 8px;
          box-shadow: 0 4px 12px rgba(0,0,0,0.1);
          text-align: center;
          width: 320px;
        }
        h2 {
          color: #28a745;
          margin-bottom: 20px;
        }
        p {
          color: #333;
          font-size: 18px;
          margin: 10px 0;
        }
        strong {
          font-size: 22px;
          color: #000;
        }
      </style>
    </head>
    <body>
      <div class="message-box">
        <h2>Signup Successful!</h2>
        <p>Your login code is: <strong>' . $code . '</strong></p>
        <p>Redirecting to login in 10 seconds...</p>
      </div>
      <script>
        setTimeout(function() {
          window.location.href = "login.html";
        }, 10000);
      </script>
    </body>
    </html>
    ';
} else {
    echo "Invalid request.";
}
?>
