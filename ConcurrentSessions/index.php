<?php
session_start();

// Database configuration
$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP password is empty
$db = 'lab_exam';

// Connect to MySQL
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

// Create table if not exists to track active sessions
$table_sql = "CREATE TABLE IF NOT EXISTS active_sessions (
    session_id VARCHAR(128) PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    last_activity INT NOT NULL
)";
$conn->query($table_sql);

// Set session timeout (5 minutes)
$timeout_duration = 5 * 60; 

// Cleanup expired sessions globally
$expire_time = time() - $timeout_duration;
$conn->query("DELETE FROM active_sessions WHERE last_activity < $expire_time");

// Handle Logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $session_id = session_id();
    $conn->query("DELETE FROM active_sessions WHERE session_id = '$session_id'");
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

$error_msg = "";

// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $session_id = session_id();
    
    // Check concurrent sessions for this user
    $result = $conn->query("SELECT COUNT(*) as count FROM active_sessions WHERE username = '$username'");
    $row = $result->fetch_assoc();
    $active_count = $row['count'];
    
    // Allow login if less than 3 sessions, OR if they are logging in from an already active session
    $check_existing = $conn->query("SELECT * FROM active_sessions WHERE session_id = '$session_id' AND username = '$username'");
    
    if ($active_count >= 3 && $check_existing->num_rows == 0) {
        $error_msg = "Maximum concurrent sessions (3) reached for user: $username. Please wait for a session to expire or logout from another device.";
    } else {
        // Register/Update session
        $current_time = time();
        $conn->query("REPLACE INTO active_sessions (session_id, username, last_activity) VALUES ('$session_id', '$username', $current_time)");
        $_SESSION['username'] = $username;
        $_SESSION['last_activity'] = $current_time;
        header("Location: index.php");
        exit();
    }
}

// Update activity if already logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $session_id = session_id();
    
    // Check if session has expired due to inactivity
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
        // Session expired
        $conn->query("DELETE FROM active_sessions WHERE session_id = '$session_id'");
        session_unset();
        session_destroy();
        $error_msg = "Your session has expired due to 5 minutes of inactivity. Please login again.";
    } else {
        // Update last activity
        $current_time = time();
        $_SESSION['last_activity'] = $current_time;
        $conn->query("UPDATE active_sessions SET last_activity = $current_time WHERE session_id = '$session_id'");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concurrent Sessions Limit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-top: 0;
            color: #444;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: #d9534f;
            background: #fdf7f7;
            padding: 10px;
            border-radius: 4px;
            margin-top: 15px;
            font-size: 14px;
            border: 1px solid #d9534f;
        }
        .success {
            color: #28a745;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .logout-btn {
            background-color: #dc3545;
            margin-top: 20px;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .info {
            background: #e9ecef;
            padding: 15px;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 15px;
            text-align: left;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($_SESSION['username'])): ?>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div class="success">You are logged in successfully.</div>
        
        <div class="info">
            <strong>Session Info:</strong><br>
            - Timeout: 5 minutes of inactivity.<br>
            - Concurrent Limit: 3 sessions per user.<br><br>
            <em>To test the limit, open this page in other browsers or incognito windows and login with the same username.</em>
        </div>

        <form action="index.php?action=logout" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    <?php else: ?>
        <h2>User Login</h2>
        <p>Login to test concurrent session limits.</p>
        
        <form action="index.php" method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <button type="submit">Login</button>
        </form>
        
        <?php if ($error_msg): ?>
            <div class="error"><?php echo htmlspecialchars($error_msg); ?></div>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
