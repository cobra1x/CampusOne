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

// Process form submission for adding marks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_marks'])) {
    $student_id = (int)$_POST['student_id'];
    $exam_type = sanitize($_POST['exam_type']);
    $subject = sanitize($_POST['subject']);
    $marks = (float)$_POST['marks'];
    $max_marks = (float)$_POST['max_marks'];
    
    // Check if marks already exist
    $check_sql = "SELECT * FROM marks WHERE student_id = $student_id AND exam_type = '$exam_type' AND subject = '$subject'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Update existing marks
        $sql = "UPDATE marks SET marks = $marks, max_marks = $max_marks WHERE student_id = $student_id AND exam_type = '$exam_type' AND subject = '$subject'";
        $message = "Marks updated successfully";
    } else {
        // Insert new marks
        $sql = "INSERT INTO marks (student_id, faculty_id, exam_type, subject, marks, max_marks) 
                VALUES ($student_id, $faculty_id, '$exam_type', '$subject', $marks, $max_marks)";
        $message = "Marks added successfully";
    }
    
    if (mysqli_query($conn, $sql)) {
        $success = $message;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Get all students in the department
$sql_students = "SELECT * FROM students WHERE department = '$faculty_department' ORDER BY name";
$result_students = mysqli_query($conn, $sql_students);
?>
<?php include_once("../includes/header.php"); ?>

<h2>Add/Update Exam Marks</h2>

<?php if (isset($success)): ?>
<div class="message success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="message error"><?php echo $error; ?></div>
<?php endif; ?>

<div class="form-container" style="max-width: 600px;">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="student_id">Select Student:</label>
            <select id="student_id" name="student_id" class="form-control" required>
                <option value="">-- Select Student --</option>
                <?php while($student = mysqli_fetch_assoc($result_students)): ?>
                <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?> (<?php echo $student['roll_number']; ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="exam_type">Exam Type:</label>
            <select id="exam_type" name="exam_type" class="form-control" required>
                <option value="Internal 1">Internal 1</option>
                <option value="Internal 2">Internal 2</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="marks">Marks Obtained:</label>
            <input type="number" id="marks" name="marks" class="form-control" min="0" step="0.01" required>
        </div>
        
        <div class="form-group">
            <label for="max_marks">Maximum Marks:</label>
            <input type="number" id="max_marks" name="max_marks" class="form-control" min="1" step="0.01" value="100" required>
        </div>
        
        <div class="form-group">
            <button type="submit" name="add_marks" class="btn">Add/Update Marks</button>
        </div>
    </form>
</div>

<h3 style="margin-top: 30px;">View Existing Marks</h3>

<form method="get" action="view_marks.php" style="margin-bottom: 20px;">
    <div class="form-group">
        <label for="view_student">Select Student to View Marks:</label>
        <select id="view_student" name="student_id" class="form-control" required>
            <option value="">-- Select Student --</option>
            <?php 
            // Reset the result pointer to beginning
            mysqli_data_seek($result_students, 0);
            while($student = mysqli_fetch_assoc($result_students)): 
            ?>
            <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?> (<?php echo $student['roll_number']; ?>)</option>
            <?php endwhile; ?>
        </select>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn">View Marks</button>
    </div>
</form>

<?php include_once("../includes/footer.php"); ?>