<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php';

$action = $_GET['action'] ?? '';

if ($action === 'save') {
    $data = json_decode(file_get_contents("php://input"), true);

    $student_name = mysqli_real_escape_string($conn, $data['student_name']);
    $reg_no       = mysqli_real_escape_string($conn, $data['reg_no']);
    $course       = mysqli_real_escape_string($conn, $data['course']);
    $semester     = mysqli_real_escape_string($conn, $data['semester']);
    $marks        = json_encode($data['marks']);
    $total_marks  = floatval($data['total_marks']);
    $percentage   = floatval($data['percentage']);
    $status       = mysqli_real_escape_string($conn, $data['status']);

    // Check if already exists
    $check = mysqli_query($conn, "SELECT id FROM results WHERE reg_no = '$reg_no'");
    if (mysqli_num_rows($check) > 0) {
        $sql = "UPDATE results SET student_name='$student_name', course='$course', semester='$semester',
                marks='$marks', total_marks='$total_marks', percentage='$percentage', status='$status'
                WHERE reg_no='$reg_no'";
    } else {
        $sql = "INSERT INTO results (student_name, reg_no, course, semester, marks, total_marks, percentage, status)
                VALUES ('$student_name', '$reg_no', '$course', '$semester', '$marks', '$total_marks', '$percentage', '$status')";
    }

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true, "message" => "Result saved successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . mysqli_error($conn)]);
    }

} elseif ($action === 'fetch') {
    $sql = "SELECT * FROM results ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['marks'] = json_decode($row['marks'], true);
        $rows[] = $row;
    }
    echo json_encode($rows);

} elseif ($action === 'delete') {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM results WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["error" => "Invalid action"]);
}

mysqli_close($conn);
?>
