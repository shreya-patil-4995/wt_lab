-- Run this SQL in phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS semresult_db;
USE semresult_db;

CREATE TABLE IF NOT EXISTS results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    reg_no VARCHAR(20) NOT NULL UNIQUE,
    course VARCHAR(100) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    marks TEXT NOT NULL,
    total_marks FLOAT NOT NULL,
    percentage FLOAT NOT NULL,
    status VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
