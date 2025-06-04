<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

check_login("faculty");

// Check if student ID is provided
if (!isset($_GET['student_id'])) {
    redirect("add_marks.php", "Please select a student to view marks", "error");
}

$student_id = (int)$_GET['student_id'];
$faculty_department = $_SESSION['faculty_department'];

// Get student information
$sql_student = "SELECT * FROM students WHERE id = $student_id AND department = '$faculty_department'";
$result_student = mysqli_query($conn, $sql_student);

if (mysqli_num_rows($result_student) == 0) {
    redirect("add_marks.php", "Invalid student or student not in your department", "error");
}

$student = mysqli_fetch_assoc($result_student);

// Get student marks
$sql_marks = "SELECT m.*, f.name as faculty_name 
             FROM marks m 
             JOIN faculty f ON m.faculty_id = f.id 
             WHERE m.student_id = $student_id 
             ORDER BY m.exam_type, m.subject";
$result_marks = mysqli_query($conn, $sql_marks);
?>
<?php include_once("../includes/header.php"); ?>

<h2>Marks for <?php echo $student['name']; ?> (<?php echo $student['roll_number']; ?>)</h2>

<?php if (mysqli_num_rows($result_marks) > 0): ?>
<table class="data-table">
    <thead>
        <tr>
            <th>Exam Type</th>
            <th>Subject</th>
            <th>Marks</th>
            <th>Max Marks</th>
            <th>Percentage</th>
            <th>Added By</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result_marks)): ?>
        <tr>
            <td><?php echo $row['exam_type']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['marks']; ?></td>
            <td><?php echo $row['max_marks']; ?></td>
            <td><?php echo number_format(($row['marks'] / $row['max_marks']) * 100, 2); ?>%</td>
            <td><?php echo $row['faculty_name']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>No marks found for this student.</p>
<?php endif; ?>

<div style="margin-top: 20px;">
    <a href="add_marks.php" class="btn back-btn">Back to Add Marks</a>
</div>

<?php include_once("../includes/footer.php"); ?>