<?php
session_start();

// Destroy session
session_unset();
session_destroy();

// Delete the cookie by setting expiry in the past
setcookie("username", "", time() - 3600, "/");

// Redirect to login
header("Location: login.php");
exit();
?>
