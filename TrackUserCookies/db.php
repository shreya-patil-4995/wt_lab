<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "user_tracking_db";

// Connect to MySQL
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists (helpful for lab exams to avoid manual DB setup)
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    $conn->select_db($dbname);
    
    // Create users table if not exists
    $tableSql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )";
    $conn->query($tableSql);
} else {
    die("Error creating database: " . $conn->error);
}
?>
