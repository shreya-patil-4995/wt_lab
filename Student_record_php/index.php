<?php include "db.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <style>
        body { font-family: Arial; text-align: center; }
        table { margin: auto; border-collapse: collapse; }
        td, th { padding: 10px; border: 1px solid black; }
        a { padding: 5px 10px; text-decoration: none; }
        .edit { background: green; color: white; }
        .delete { background: red; color: white; }
    </style>
</head>

<body>

<h2>Student Records</h2>

<table>
<tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM students");

while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['course']}</td>
        <td>
            <a class='edit' href='edit.php?id={$row['id']}'>Edit</a>
            <a class='delete' href='delete.php?id={$row['id']}'>Delete</a>
        </td>
    </tr>";
}
?>

</table>

</body>
</html>