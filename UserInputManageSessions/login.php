<?php
session_start();

// Dummy user credentials for demo
$valid_username = "admin";
$valid_password = "1234";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');

    if ($username === $valid_username && $password === $valid_password) {
        // Create session on successful login
        $_SESSION['logged_in']    = true;
        $_SESSION['login_user']   = $username;
        $_SESSION['login_time']   = date("Y-m-d H:i:s");

        // Also set a cookie with the username
        setcookie("username", $username, time() + 3600, "/");

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f0f0; padding: 20px; }
        .container {
            background: #fff;
            padding: 25px;
            width: 380px;
            margin: 60px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 { color: #333; text-align: center; }
        label { display: block; margin-top: 12px; font-weight: bold; color: #444; }
        input[type="text"], input[type="password"] {
            width: 100%; padding: 8px; margin-top: 4px;
            box-sizing: border-box; border: 1px solid #aaa; border-radius: 3px;
        }
        input[type="submit"] {
            width: 100%; margin-top: 15px; padding: 10px;
            background-color: #4a90d9; color: white;
            border: none; border-radius: 3px; cursor: pointer; font-size: 14px;
        }
        input[type="submit"]:hover { background-color: #357abd; }
        .error { color: red; text-align: center; font-size: 13px; margin-top: 8px; }
        .hint { background: #fffbe6; border: 1px solid #f0c040; padding: 8px;
                font-size: 12px; border-radius: 3px; margin-top: 12px; }
        .nav-links { text-align: center; margin-top: 12px; }
        .nav-links a { color: #4a90d9; text-decoration: none; font-size: 14px; }
        .nav-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <h2>Session Login</h2>

    <?php if ($error): ?>
        <p class="error">&times; <?php echo $error; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <input type="submit" value="Login">
    </form>

    <div class="hint">
        <strong>Demo credentials:</strong> Username: <code>admin</code> | Password: <code>1234</code>
    </div>

    <div class="nav-links">
        <a href="index.php">&larr; Back to Registration</a>
    </div>
</div>
</body>
</html>
