<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

check_login("student");

// Get student department
$student_department = $_SESSION['student_department'];

// Get all notifications for this department
$sql = "SELECT n.*, f.name as faculty_name 
        FROM notifications n 
        JOIN faculty f ON n.faculty_id = f.id 
        WHERE n.department = '$student_department' 
        ORDER BY n.date DESC";
$result = mysqli_query($conn, $sql);
?>
<?php include_once("../includes/header.php"); ?>

<h2>Notifications</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
<div class="notification-list">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="card" style="margin-bottom: 15px;">
        <h3><?php echo $row['title']; ?></h3>
        <p style="margin-bottom: 10px;"><?php echo $row['message']; ?></p>
        <div style="font-size: 14px; color: #666; display: flex; justify-content: space-between;">
            <span>By: <?php echo $row['faculty_name']; ?></span>
            <span>Date: <?php echo date("d M Y H:i", strtotime($row['date'])); ?></span>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php else: ?>
<p>No notifications found for your department.</p>
<?php endif; ?>

<?php include_once("../includes/footer.php"); ?>