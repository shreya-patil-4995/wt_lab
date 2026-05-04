<?php include "db.php"; session_start(); ?>

<h2>All Complaints</h2>

<table border="1">
<tr>
<th>ID</th><th>Student</th><th>Complaint</th>
</tr>

<?php
$res=mysqli_query($conn,"SELECT * FROM complaints");

while($row=mysqli_fetch_assoc($res)){
echo "<tr>
<td>{$row['id']}</td>
<td>{$row['student_name']}</td>
<td>{$row['complaint']}</td>
</tr>";
}
?>
</table>

<a href="logout.php">Logout</a>