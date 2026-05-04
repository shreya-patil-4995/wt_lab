// Task 1: Configure the database connection in Node.js
const mysql = require('mysql2');

const db = mysql.createConnection({
    host: '127.0.0.1',
    user: 'root',
    password: '',       // XAMPP default: no password
    database: 'studreg'
});

db.connect((err) => {
    if (err) {
        console.error('Database connection failed:', err.message);
        return;
    }
    console.log('Connected to MySQL database.');

    // Task 2: Create Student table with id, name, email, course
    const createTableQuery = `
        CREATE TABLE IF NOT EXISTS students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            course VARCHAR(100) NOT NULL
        )
    `;

    db.query(createTableQuery, (err) => {
        if (err) {
            console.error('Error creating table:', err.message);
        } else {
            console.log('Students table ready.');
        }
    });
});

module.exports = db;
