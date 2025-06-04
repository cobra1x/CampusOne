<?php

session_start();

include_once("../includes/config.php");
include_once("../includes/functions.php");

check_login("student");

// Get student department
$student_department = $_SESSION['student_department'];

// Get all faculty in the department
$sql = "SELECT * FROM faculty WHERE department = '$student_department' ORDER BY name";
$result = mysqli_query($conn, $sql);
?>
<?php include_once("../includes/header.php"); ?>

<h2>Faculty in <?php echo $student_department; ?> Department</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
<div class="faculty-list">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="card" style="margin-bottom: 20px;">
        <h3><?php echo $row['name']; ?></h3>
        <div class="profile-details">
            <p><strong>Department:</strong> <?php echo $row['department']; ?></p>
            <p><strong>Education:</strong> <?php echo $row['education']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php else: ?>
<p>No faculty found in your department.</p>
<?php endif; ?>

<?php include_once("../includes/footer.php"); ?>