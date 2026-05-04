<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
<title>Waste Collection System</title>
<style>
body{text-align:center;font-family:Arial;}
form{width:300px;margin:auto;}
input,textarea,select{width:100%;padding:8px;margin:5px;}
</style>
</head>

<body>

<h2>Report Waste</h2>

<form method="POST">
<select name="type">
<option>Plastic</option>
<option>Paper</option>
<option>Other</option>
</select>

<input type="text" name="location" placeholder="Enter Location" required>

<textarea name="desc" placeholder="Description"></textarea>

<button type="submit" name="submit">Report</button>
</form>

<br>
<a href="view.php">View Reports</a>

<?php
if(isset($_POST['submit'])){
$type=$_POST['type'];
$loc=$_POST['location'];
$desc=$_POST['desc'];

mysqli_query($conn,"INSERT INTO waste_reports(type,location,description)
VALUES('$type','$loc','$desc')");

echo "<p>Reported Successfully</p>";
}
?>

</body>
</html>