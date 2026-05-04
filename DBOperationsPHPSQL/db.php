<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "student_db";

// Create connection
$conn = mysqli_connect($host, $user, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS student_db";
mysqli_query($conn, $sql);

// Select the database
mysqli_select_db($conn, $dbname);

// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
)";
mysqli_query($conn, $sql);
?>
