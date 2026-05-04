<?php
session_start();
require 'db.php';

// Check if already logged in via session or tracked by cookie
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
} elseif (isset($_COOKIE['remember_user'])) {
    // Restore session from cookie
    $_SESSION['user_id'] = $_COOKIE['remember_user'];
    $_SESSION['username'] = $_COOKIE['remember_username'];
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // Set Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Set Cookie to track user for 30 days
            setcookie("remember_user", $row['id'], time() + (86400 * 30), "/");
            setcookie("remember_username", $row['username'], time() + (86400 * 30), "/");

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "<div class='error'>Invalid password!</div>";
        }
    } else {
        $error = "<div class='error'>User not found!</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <?php echo $error; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="links">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>
