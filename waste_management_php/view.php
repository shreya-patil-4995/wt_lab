<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
<title>Waste Reports</title>
<style>
table{margin:auto;border-collapse:collapse;}
td,th{padding:10px;border:1px solid black;}
</style>
</head>

<body>

<h2>Waste Reports</h2>

<table>
<tr>
<th>ID</th><th>Type</th><th>Location</th>
<th>Description</th><th>Status</th>
</tr>

<?php
$res=mysqli_query($conn,"SELECT * FROM waste_reports");

while($row=mysqli_fetch_assoc($res)){
echo "<tr>
<td>{$row['id']}</td>
<td>{$row['type']}</td>
<td>{$row['location']}</td>
<td>{$row['description']}</td>
<td>{$row['status']}</td>
</tr>";
}
?>

</table>

<br>
<a href="index.php">Back</a>

</body>
</html>