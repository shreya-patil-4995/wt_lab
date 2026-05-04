<?php
session_start();

// Check session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$cookie_status = isset($_COOKIE['remember_user']) ? "Active (Tracking enabled)" : "Not Set";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <p>You are successfully logged in using <strong>Sessions</strong>.</p>
        <p>User tracking <strong>Cookie</strong> status: <?php echo $cookie_status; ?></p>
        <br>
        <a href="logout.php" class="btn" style="display:inline-block; text-decoration:none; width:auto; padding:10px 20px;">Logout</a>
    </div>
</body>
</html>
