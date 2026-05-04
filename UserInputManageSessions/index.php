<?php
// Start session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        .container {
            background-color: #fff;
            padding: 25px;
            width: 400px;
            margin: 40px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
            color: #444;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            box-sizing: border-box;
            border: 1px solid #aaa;
            border-radius: 3px;
        }
        input[type="submit"] {
            margin-top: 15px;
            padding: 9px 20px;
            background-color: #4a90d9;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }
        input[type="submit"]:hover {
            background-color: #357abd;
        }
        .nav-links {
            text-align: center;
            margin-top: 12px;
        }
        .nav-links a {
            color: #4a90d9;
            text-decoration: none;
            font-size: 14px;
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
        .msg {
            color: green;
            font-size: 13px;
            margin-top: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Register (GET Method)</h2>
    <p style="font-size:13px; color:#666;">Form data sent via GET (visible in URL)</p>

    <form action="get_process.php" method="GET">
        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter your name" required>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <input type="submit" value="Submit via GET">
    </form>

    <div class="nav-links">
        <a href="post_form.php">Go to POST Form &rarr;</a> |
        <a href="login.php">Login Page &rarr;</a>
    </div>
</div>

</body>
</html>
