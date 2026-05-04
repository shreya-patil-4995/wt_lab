<?php include "db.php"; session_start(); ?>

<form method="POST">
<h2>Student Login</h2>
<input type="text" name="user" placeholder="Username" required><br>
<input type="password" name="pass" placeholder="Password" required><br>
<button name="login">Login</button>
</form>

<?php
if(isset($_POST['login'])){
$u=$_POST['user'];
$p=$_POST['pass'];

$res=mysqli_query($conn,"SELECT * FROM students WHERE username='$u' AND password='$p'");

if(mysqli_num_rows($res)>0){
$_SESSION['student']=$u;
header("Location: student_home.php");
}else{
echo "Invalid Login";
}
}
?>