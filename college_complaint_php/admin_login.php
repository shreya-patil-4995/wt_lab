<?php include "db.php"; session_start(); ?>

<form method="POST">
<h2>Admin Login</h2>
<input type="text" name="user" placeholder="Username"><br>
<input type="password" name="pass" placeholder="Password"><br>
<button name="login">Login</button>
</form>

<?php
if(isset($_POST['login'])){
$u=$_POST['user'];
$p=$_POST['pass'];

$res=mysqli_query($conn,"SELECT * FROM admin WHERE username='$u' AND password='$p'");

if(mysqli_num_rows($res)>0){
$_SESSION['admin']=$u;
header("Location: admin_home.php");
}else{
echo "Invalid Login";
}
}
?>