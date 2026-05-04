<?php
// Process GET form data
$name = "";
$email = "";
$password = "";
$error = "";

if (isset($_GET['name'], $_GET['email'], $_GET['password'])) {
    $name     = htmlspecialchars($_GET['name']);
    $email    = htmlspecialchars($_GET['email']);
    $password = htmlspecialchars($_GET['password']);

    // Validate email format using filter_var
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Set a cookie to store the username (expires in 1 hour)
        setcookie("username", $name, time() + 3600, "/");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GET Form Result</title>
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
        .url-box {
            background: #f9f9f9;
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 12px;
            word-break: break-all;
            margin-top: 10px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>GET Method - Form Output</h2>

    <?php if ($error): ?>
        <p class="error">&times; <?php echo $error; ?></p>
    <?php elseif ($name): ?>
        <p class="success">&#10003; Form submitted successfully!</p>

        <table>
            <tr><th>Field</th><th>Value</th></tr>
            <tr><td>Name</td><td><?php echo $name; ?></td></tr>
            <tr><td>Email</td><td><?php echo $email; ?></td></tr>
            <tr><td>Password</td><td><?php echo str_repeat('*', strlen($password)); ?></td></tr>
        </table>

        <p style="font-size:13px; margin-top:12px; color:#555;">
            <strong>Cookie Set:</strong> <code>username = <?php echo $name; ?></code> (valid 1 hour)
        </p>

        <div class="url-box">
            <strong>GET URL:</strong> <?php echo $_SERVER['REQUEST_URI']; ?>
        </div>

        <p style="font-size:13px; color:#555; margin-top:10px;">
            <strong>Cookie Check:</strong>
            <?php
            if (isset($_COOKIE['username'])) {
                echo "Cookie 'username' = <strong>" . htmlspecialchars($_COOKIE['username']) . "</strong>";
            } else {
                echo "Cookie will be available on next page load.";
            }
            ?>
        </p>
    <?php else: ?>
        <p class="error">No data received. Please fill out the form.</p>
    <?php endif; ?>

    <a class="back" href="index.php">&larr; Back to GET Form</a> |
    <a class="back" href="post_form.php">Go to POST Form &rarr;</a>
</div>
</body>
</html>
