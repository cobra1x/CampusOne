<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "student_management";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set character set
mysqli_set_charset($conn, "utf8");
?>