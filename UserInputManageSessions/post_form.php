<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POST Form</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f0f0; padding: 20px; }
        .container {
            background: #fff;
            padding: 25px;
            width: 400px;
            margin: 40px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 { color: #333; }
        label { display: block; margin-top: 12px; font-weight: bold; color: #444; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 8px; margin-top: 4px;
            box-sizing: border-box; border: 1px solid #aaa; border-radius: 3px;
        }
        input[type="submit"] {
            margin-top: 15px; padding: 9px 20px;
            background-color: #5cb85c; color: white;
            border: none; border-radius: 3px; cursor: pointer; font-size: 14px;
        }
        input[type="submit"]:hover { background-color: #4cae4c; }
        .nav-links { text-align: center; margin-top: 12px; }
        .nav-links a { color: #4a90d9; text-decoration: none; font-size: 14px; }
        .nav-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <h2>Register (POST Method)</h2>
    <p style="font-size:13px; color:#666;">Form data sent via POST (not visible in URL)</p>

    <form action="post_process.php" method="POST">
        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter your name" required>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <input type="submit" value="Submit via POST">
    </form>

    <div class="nav-links">
        <a href="index.php">&larr; Back to GET Form</a> |
        <a href="login.php">Login Page &rarr;</a>
    </div>
</div>
</body>
</html>
