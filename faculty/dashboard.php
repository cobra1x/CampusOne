<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

// Check if faculty is logged in
check_login("faculty");

// Get faculty information
$faculty_id = $_SESSION['faculty'];
$faculty_department = $_SESSION['faculty_department'];

// Get student count in department
$sql_students = "SELECT COUNT(*) as count FROM students WHERE department = '$faculty_department'";
$result_students = mysqli_query($conn, $sql_students);
$student_count = mysqli_fetch_assoc($result_students)['count'];

// Get notification count
$sql_notifications = "SELECT COUNT(*) as count FROM notifications WHERE faculty_id = $faculty_id";
$result_notifications = mysqli_query($conn, $sql_notifications);
$notification_count = mysqli_fetch_assoc($result_notifications)['count'];
?>
<?php include_once("../includes/header.php"); ?>

<h2>Faculty Dashboard</h2>

<div class="dashboard-cards">
    <div class="card">
        <h3>My Profile</h3>
        <p>View and update your profile</p>
        <a href="profile.php" class="btn">View Profile</a>
    </div>
    
    <div class="card">
        <h3>Students</h3>
        <p>Total Students in Department: <?php echo $student_count; ?></p>
        <a href="view_students.php" class="btn">View Students</a>
    </div>
    
    <div class="card">
        <h3>Notifications</h3>
        <p>Notifications Sent: <?php echo $notification_count; ?></p>
        <a href="add_notification.php" class="btn">Send Notification</a>
    </div>
    
    <div class="card">
        <h3>Exam Marks</h3>
        <p>Manage student exam marks</p>
        <a href="add_marks.php" class="btn">Add/Update Marks</a>
    </div>
</div>

<div class="card">
    <h3>Welcome, <?php echo $_SESSION['faculty_name']; ?></h3>
    <p>You are logged in as a faculty member of the <?php echo $faculty_department; ?> department.</p>
    <p>Here, you can manage your profile, view students in your department, send notifications, and add exam marks.</p>
</div>

<?php include_once("../includes/footer.php"); ?>