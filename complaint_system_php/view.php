<?php include "db.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>View Complaints</title>
    <style>
        body { text-align: center; font-family: Arial; }
        table { margin: auto; border-collapse: collapse; }
        td, th { padding: 10px; border: 1px solid black; }
    </style>
</head>

<body>

<h2>All Complaints</h2>

<table>
<tr>
    <th>ID</th><th>Name</th><th>Email</th>
    <th>Organization</th><th>Complaint</th><th>Status</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM complaints");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['organization']}</td>
        <td>{$row['complaint']}</td>
        <td>{$row['status']}</td>
    </tr>";
}
?>

</table>

<br>
<a href="index.php">Back</a>

</body>
</html>