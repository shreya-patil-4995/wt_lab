<?php include "db.php"; session_start(); ?>

<h2>Welcome <?php echo $_SESSION['student']; ?></h2>

<form method="POST">
<textarea name="comp" placeholder="Enter Complaint"></textarea><br>
<button name="submit">Submit Complaint</button>
</form>

<a href="logout.php">Logout</a>

<?php
if(isset($_POST['submit'])){
$c=$_POST['comp'];
$u=$_SESSION['student'];

mysqli_query($conn,"INSERT INTO complaints(student_name,complaint)
VALUES('$u','$c')");

echo "Complaint Submitted";
}
?>