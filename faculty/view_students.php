<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

check_login("faculty");

// Get faculty department
$faculty_department = $_SESSION['faculty_department'];

// Get all students in the department
$sql = "SELECT * FROM students WHERE department = '$faculty_department' ORDER BY name";
$result = mysqli_query($conn, $sql);
?>
<?php include_once("../includes/header.php"); ?>

<h2>Students in <?php echo $faculty_department; ?> Department</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Roll Number</th>
            <th>Semester</th>
            <th>Admission Year</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['roll_number']; ?></td>
            <td><?php echo $row['semester']; ?></td>
            <td><?php echo $row['admission_year']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>No students found in your department.</p>
<?php endif; ?>

<?php include_once("../includes/footer.php"); ?>