<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$username   = $_SESSION['login_user'];
$login_time = $_SESSION['login_time'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f0f0; padding: 20px; }
        .container {
            background: #fff;
            padding: 25px;
            width: 440px;
            margin: 60px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 { color: #333; }
        .welcome {
            background-color: #dff0d8;
            border: 1px solid #c3e6cb;
            padding: 12px;
            border-radius: 4px;
            color: #2d6a2d;
            font-size: 15px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 9px 12px; border: 1px solid #ddd; text-align: left; font-size: 14px; }
        th { background-color: #e8e8e8; }
        .logout-btn {
            display: inline-block;
            margin-top: 18px;
            padding: 9px 20px;
            background-color: #d9534f;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            font-size: 14px;
        }
        .logout-btn:hover { background-color: #c9302c; }
        .session-info {
            font-size: 13px;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Dashboard</h2>

    <div class="welcome">
        &#10003; Welcome, <strong><?php echo htmlspecialchars($username); ?></strong>! You are logged in.
    </div>

    <table>
        <tr><th>Session Key</th><th>Value</th></tr>
        <tr><td>$_SESSION['logged_in']</td><td>true</td></tr>
        <tr><td>$_SESSION['login_user']</td><td><?php echo htmlspecialchars($username); ?></td></tr>
        <tr><td>$_SESSION['login_time']</td><td><?php echo $login_time; ?></td></tr>
    </table>

    <p class="session-info">
        <strong>Cookie:</strong>
        <?php
        if (isset($_COOKIE['username'])) {
            echo "username = <strong>" . htmlspecialchars($_COOKIE['username']) . "</strong>";
        } else {
            echo "Cookie not found (may need page refresh).";
        }
        ?>
    </p>

    <p class="session-info">
        <strong>Session ID:</strong> <code><?php echo session_id(); ?></code>
    </p>

    <a class="logout-btn" href="logout.php">Logout</a>
</div>
</body>
</html>
