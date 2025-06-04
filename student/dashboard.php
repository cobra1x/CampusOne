<?php
// Start session
session_start();

include_once("../includes/config.php");
include_once("../includes/functions.php");

check_login("student");

// Get student information
$student_id = $_SESSION['student'];
$student_department = $_SESSION['student_department'];

// Get notification count
$sql_notifications = "SELECT COUNT(*) as count FROM notifications WHERE department = '$student_department'";
$result_notifications = mysqli_query($conn, $sql_notifications);
$notification_count = mysqli_fetch_assoc($result_notifications)['count'];

// Get faculty count in department
$sql_faculty = "SELECT COUNT(*) as count FROM faculty WHERE department = '$student_department'";
$result_faculty = mysqli_query($conn, $sql_faculty);
$faculty_count = mysqli_fetch_assoc($result_faculty)['count'];

// Get marks count
$sql_marks = "SELECT COUNT(*) as count FROM marks WHERE student_id = $student_id";
$result_marks = mysqli_query($conn, $sql_marks);
$marks_count = mysqli_fetch_assoc($result_marks)['count'];
?>
<?php include_once("../includes/header.php"); ?>

<h2>Student Dashboard</h2>

<div class="dashboard-cards">
    <div class="card">
        <h3>My Profile</h3>
        <p>View your profile information</p>
        <a href="profile.php" class="btn">View Profile</a>
    </div>
    
    <div class="card">
        <h3>Notifications</h3>
        <p>Total Notifications: <?php echo $notification_count; ?></p>
        <a href="view_notifications.php" class="btn">View Notifications</a>
    </div>
    
    <div class="card">
        <h3>Exam Marks</h3>
        <p>Total Subjects: <?php echo $marks_count; ?></p>
        <a href="view_marks.php" class="btn">View Marks</a>
    </div>
    
    <div class="card">
        <h3>Faculty</h3>
        <p>Department Faculty: <?php echo $faculty_count; ?></p>
        <a href="view_faculty.php" class="btn">View Faculty</a>
    </div>
</div>

<div class="card">
    <h3>Welcome, <?php echo $_SESSION['student_name']; ?></h3>
    <p>You are logged in as a student in the <?php echo $student_department; ?> department.</p>
    <p>Here you can view your profile information, check notifications from faculty, view your exam marks, and see faculty details.</p>
</div>

<?php include_once("../includes/footer.php"); ?>