<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

// Check if admin is logged in
check_login("admin");

// Get counts for dashboard
$sql_faculty = "SELECT COUNT(*) as count FROM faculty";
$result_faculty = mysqli_query($conn, $sql_faculty);
$faculty_count = mysqli_fetch_assoc($result_faculty)['count'];

$sql_students = "SELECT COUNT(*) as count FROM students";
$result_students = mysqli_query($conn, $sql_students);
$student_count = mysqli_fetch_assoc($result_students)['count'];
?>
<?php include_once("../includes/header.php"); ?>

<h2>Admin Dashboard</h2>

<div class="dashboard-cards">
    <div class="card">
        <h3>Faculty Management</h3>
        <p>Total Faculty: <?php echo $faculty_count; ?></p>
        <a href="manage_faculty.php" class="btn">Manage Faculty</a>
    </div>
    
    <div class="card">
        <h3>Student Management</h3>
        <p>Total Students: <?php echo $student_count; ?></p>
        <a href="manage_students.php" class="btn">Manage Students</a>
    </div>
</div>

<div class="card">
    <h3>System Information</h3>
    <p>Welcome to the admin panel. From here you can manage faculty and student accounts.</p>
    <p>As an administrator, you have the ability to:</p>
    <ul>
        <li>Create, update, and delete faculty accounts</li>
        <li>Create, update, and delete student accounts</li>
        <li>View system statistics</li>
    </ul>
</div>

<?php include_once("../includes/footer.php"); ?>