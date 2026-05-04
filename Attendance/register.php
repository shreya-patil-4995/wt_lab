<?php
require 'db.php';
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = trim($_POST['roll_no']);
    $name = trim($_POST['name']);

    if (!empty($roll_no) && !empty($name)) {
        $stmt = $conn->prepare("INSERT INTO students (roll_no, name) VALUES (?, ?)");
        $stmt->bind_param("ss", $roll_no, $name);
        
        if ($stmt->execute()) {
            $msg = "<div class='msg success'>Student registered successfully!</div>";
        } else {
            if ($conn->errno == 1062) { // MySQL Duplicate entry error code
                $msg = "<div class='msg error'>Roll Number already exists!</div>";
            } else {
                $msg = "<div class='msg error'>Error: " . $conn->error . "</div>";
            }
        }
        $stmt->close();
    } else {
        $msg = "<div class='msg error'>Please fill all fields.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Student Registration</h2>
        <div class="nav">
            <a href="index.php">Home</a>
            <a href="attendance.php">Take Attendance</a>
            <a href="view_attendance.php">View Attendance</a>
        </div>
        
        <?php echo $msg; ?>
        
        <form method="POST" action="">
            <label for="roll_no">Roll Number:</label>
            <input type="text" name="roll_no" id="roll_no" placeholder="Enter Roll Number" required>
            
            <label for="name">Student Name:</label>
            <input type="text" name="name" id="name" placeholder="Enter Full Name" required>
            
            <input type="submit" value="Register Student">
        </form>
    </div>
</body>
</html>
