<?php
require 'db.php';
$msg = '';

// Fetch all students
$result = $conn->query("SELECT * FROM students ORDER BY roll_no ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attendance_date = $_POST['attendance_date'];
    
    if (empty($attendance_date)) {
        $msg = "<div class='msg error'>Please select a date.</div>";
    } else {
        $students = $conn->query("SELECT id FROM students");
        $success_count = 0;
        
        while ($row = $students->fetch_assoc()) {
            $student_id = $row['id'];
            // If the checkbox is checked for this student ID, they are Present, else Absent
            $status = isset($_POST['status'][$student_id]) ? 'Present' : 'Absent';
            
            // Insert or update attendance for the selected date
            $stmt = $conn->prepare("INSERT INTO attendance (student_id, attendance_date, status) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status = ?");
            $stmt->bind_param("isss", $student_id, $attendance_date, $status, $status);
            if ($stmt->execute()) {
                $success_count++;
            }
            $stmt->close();
        }
        $msg = "<div class='msg success'>Attendance successfully saved for $success_count students on " . htmlspecialchars($attendance_date) . ".</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Attendance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Take Attendance</h2>
        <div class="nav">
            <a href="index.php">Home</a>
            <a href="register.php">Student Registration</a>
            <a href="view_attendance.php">View Attendance</a>
        </div>
        
        <?php echo $msg; ?>
        
        <?php if ($result && $result->num_rows > 0): ?>
        <form method="POST" action="">
            <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <label for="attendance_date" style="margin-top: 0;">Select Date:</label>
                <input type="date" name="attendance_date" id="attendance_date" value="<?php echo date('Y-m-d'); ?>" style="margin-top: 0; width: 200px;" required>
            </div>
            
            <table>
                <tr>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th class="text-center">Present (Check)</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td class="text-center">
                        <input type="checkbox" name="status[<?php echo $row['id']; ?>]" value="Present" checked>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
            
            <input type="submit" value="Save Attendance">
        </form>
        <?php else: ?>
            <p style="text-align:center; padding: 20px;">
                No students registered yet. <br><br>
                <a href="register.php" style="color: #3498db; text-decoration: none; font-weight: bold;">Click here to register students first</a>.
            </p>
        <?php endif; ?>
    </div>
</body>
</html>
