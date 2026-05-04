<?php
session_start();

// Destroy session
session_unset();
session_destroy();

// Destroy tracking cookies by setting expiration time to past
if (isset($_COOKIE['remember_user'])) {
    setcookie("remember_user", "", time() - 3600, "/");
}
if (isset($_COOKIE['remember_username'])) {
    setcookie("remember_username", "", time() - 3600, "/");
}

header("Location: login.php");
exit();
?>
