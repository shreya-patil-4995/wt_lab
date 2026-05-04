const express = require('express');
const path = require('path');
const db = require('./db');

const app = express();
const PORT = 4000;

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// Task 3: Insert a new student record via POST /register
app.post('/register', (req, res) => {
    const { name, email, course } = req.body;

    if (!name || !email || !course) {
        return res.status(400).json({ message: 'All fields are required.' });
    }

    const query = 'INSERT INTO students (name, email, course) VALUES (?, ?, ?)';
    db.query(query, [name, email, course], (err, result) => {
        if (err) {
            if (err.code === 'ER_DUP_ENTRY') {
                return res.status(409).json({ message: 'Email already registered.' });
            }
            return res.status(500).json({ message: 'Database error: ' + err.message });
        }
        res.json({ message: 'Student registered successfully!', id: result.insertId });
    });
});

// Task 4 & 5: Retrieve all students and return as JSON → /students
app.get('/students', (req, res) => {
    const query = 'SELECT * FROM students ORDER BY id ASC';
    db.query(query, (err, results) => {
        if (err) {
            return res.status(500).json({ message: 'Database error: ' + err.message });
        }
        res.json(results);
    });
});

// Serve the main HTML page
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

app.listen(PORT, () => {
    console.log(`Server running at http://localhost:${PORT}`);
});
