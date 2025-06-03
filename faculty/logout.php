<?php
// Start session
session_start();

// Unset faculty session variables
unset($_SESSION['faculty']);
unset($_SESSION['faculty_name']);
unset($_SESSION['faculty_department']);

// Redirect to login page
header("Location: login.php");
exit();
?>