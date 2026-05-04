<?php
session_start();

$name = "";
$email = "";
$password = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = htmlspecialchars($_POST['name'] ?? '');
    $email    = htmlspecialchars($_POST['email'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Set cookie to store username (expires in 1 hour)
        setcookie("username", $name, time() + 3600, "/");

        // Store user info in session
        $_SESSION['user_name']  = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['registered'] = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POST Form Result</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f0f0; padding: 20px; }
        .container {
            background: #fff;
            padding: 25px;
            width: 420px;
            margin: 40px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 9px 12px; border: 1px solid #ddd; text-align: left; font-size: 14px; }
        th { background-color: #e8e8e8; }
        .error { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }
        .back { display: inline-block; margin-top: 15px; color: #4a90d9; text-decoration: none; font-size: 14px; }
        .back:hover { text-decoration: underline; }
        .info-box {
            background: #f9f9f9;
            border-left: 3px solid #5cb85c;
            padding: 10px;
            font-size: 13px;
            margin-top: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>POST Method - Form Output</h2>

    <?php if ($error): ?>
        <p class="error">&times; <?php echo $error; ?></p>
    <?php elseif ($name): ?>
        <p class="success">&#10003; Form submitted successfully via POST!</p>

        <table>
            <tr><th>Field</th><th>Value</th></tr>
            <tr><td>Name</td><td><?php echo $name; ?></td></tr>
            <tr><td>Email</td><td><?php echo $email; ?></td></tr>
            <tr><td>Password</td><td><?php echo str_repeat('*', strlen($password)); ?></td></tr>
        </table>

        <div class="info-box">
            <strong>Cookie Set:</strong> <code>username = <?php echo $name; ?></code> (1 hour)<br>
            <strong>Session Set:</strong> <code>$_SESSION['user_name'] = <?php echo $name; ?></code>
        </div>

        <p style="font-size:13px; color:#555; margin-top:10px;">
            <em>Note: POST data is NOT visible in the URL (unlike GET).</em>
        </p>

        <a class="back" href="login.php">Go to Login &rarr;</a>
    <?php else: ?>
        <p class="error">No POST data received.</p>
    <?php endif; ?>

    <br>
    <a class="back" href="post_form.php">&larr; Back to POST Form</a>
</div>
</body>
</html>
