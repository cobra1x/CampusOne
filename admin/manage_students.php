<?php
// Start session
session_start();

include_once("../includes/config.php");
include_once("../includes/functions.php");

check_login("admin");

// Delete student if requested
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM students WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        redirect("manage_students.php", "Student deleted successfully", "success");
    } else {
        redirect("manage_students.php", "Error deleting student: " . mysqli_error($conn), "error");
    }
}

// Get all students
$sql = "SELECT * FROM students ORDER BY name";
$result = mysqli_query($conn, $sql);
?>
<?php include_once("../includes/header.php"); ?>

<h2>Manage Students</h2>

<div class="action-buttons" style="margin-bottom: 20px;">
    <a href="add_student.php" class="btn">Add New Student</a>
</div>

<?php if (mysqli_num_rows($result) > 0): ?>
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Roll Number</th>
            <th>Semester</th>
            <th>Admission Year</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td><?php echo $row['roll_number']; ?></td>
            <td><?php echo $row['semester']; ?></td>
            <td><?php echo $row['admission_year']; ?></td>
            <td class="action-buttons">
                <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                <a href="manage_students.php?delete=<?php echo $row['id']; ?>" class="btn delete-btn">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>No students found.</p>
<?php endif; ?>

<?php include_once("../includes/footer.php"); ?>