<?php
include "db.php";

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<body>

<h2>Edit Student</h2>

<form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
    Email: <input type="text" name="email" value="<?php echo $row['email']; ?>"><br><br>
    Course: <input type="text" name="course" value="<?php echo $row['course']; ?>"><br><br>

    <button type="submit">Update</button>
</form>

</body>
</html>