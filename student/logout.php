<?php
// Start session
session_start();

// Unset student session variables
unset($_SESSION['student']);
unset($_SESSION['student_name']);
unset($_SESSION['student_department']);

// Redirect to login page
header("Location: login.php");
exit();
?>