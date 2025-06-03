<?php
// Start session
session_start();

// Unset admin session
unset($_SESSION['admin']);

// Redirect to login page
header("Location: login.php");
exit();
?>