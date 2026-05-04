<?php
require 'db.php';

$filter_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$sql = "SELECT s.roll_no, s.name, a.status 
        FROM students s 
        LEFT JOIN attendance a ON s.id = a.student_id AND a.attendance_date = ?
        ORDER BY s.roll_no ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $filter_date);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .present { color: #2ecc71; font-weight: bold; }
        .absent { color: #e74c3c; font-weight: bold; }
        .not-marked { color: #95a5a6; font-style: italic; }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Attendance</h2>
        <div class="nav">
            <a href="index.php">Home</a>
            <a href="register.php">Student Registration</a>
            <a href="attendance.php">Take Attendance</a>
        </div>
        
        <form method="GET" action="" style="flex-direction: row; align-items: center; justify-content: center; gap: 15px; margin-bottom: 30px;">
            <label for="date" style="margin-top: 0;">Select Date:</label>
            <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($filter_date); ?>" style="margin-top: 0; padding: 8px;">
            <button type="submit" style="margin-top: 0; padding: 9px 20px;">Filter</button>
        </form>

        <table>
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th class="text-center">Status</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td class="text-center">
                        <?php 
                        if ($row['status'] == 'Present') {
                            echo "<span class='present'>Present</span>";
                        } elseif ($row['status'] == 'Absent') {
                            echo "<span class='absent'>Absent</span>";
                        } else {
                            echo "<span class='not-marked'>Not Marked</span>";
                        }
                        ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3" class="text-center" style="padding: 30px;">No records found for this date.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
