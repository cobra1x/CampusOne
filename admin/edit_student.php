<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

// Check if admin is logged in
check_login("admin");

// Check if ID is provided
if (!isset($_GET['id'])) {
    redirect("manage_students.php", "Invalid student ID", "error");
}

$id = (int)$_GET['id'];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $department = sanitize($_POST['department']);
    $roll_number = sanitize($_POST['roll_number']);
    $semester = (int)$_POST['semester'];
    $admission_year = (int)$_POST['admission_year'];
    $username = sanitize($_POST['username']);
    
    // Check if password should be updated
    $password_sql = "";
    if (!empty($_POST['password'])) {
        $password = sanitize($_POST['password']); // In real system, hash this password
        $password_sql = ", password = '$password'";
    }
    
    // Update student
    $sql = "UPDATE students SET 
            name = '$name', 
            email = '$email', 
            phone = '$phone', 
            department = '$department', 
            roll_number = '$roll_number', 
            semester = $semester, 
            admission_year = $admission_year, 
            username = '$username'
            $password_sql
            WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        redirect("manage_students.php", "Student updated successfully", "success");
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
} else {
    // Get student data
    $sql = "SELECT * FROM students WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $student = mysqli_fetch_assoc($result);
    } else {
        redirect("manage_students.php", "Student not found", "error");
    }
}
?>
<?php include_once("../includes/header.php"); ?>

<h2>Edit Student</h2>

<?php if (isset($error)): ?>
<div class="message error"><?php echo $error; ?></div>
<?php endif; ?>

<div class="form-container" style="max-width: 600px;">
    <form id="userForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $student['name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $student['email']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $student['phone']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="department">Department:</label>
            <select id="department" name="department" class="form-control" required>
                <option value="CSE" <?php if($student['department'] == 'CSE') echo 'selected'; ?>>Computer Science (CSE)</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="roll_number">Roll Number:</label>
            <input type="text" id="roll_number" name="roll_number" class="form-control" value="<?php echo $student['roll_number']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="semester">Semester:</label>
            <select id="semester" name="semester" class="form-control" required>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?php echo $i; ?>" <?php if($student['semester'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="admission_year">Admission Year:</label>
            <select id="admission_year" name="admission_year" class="form-control" required>
                <?php 
                $current_year = (int)date("Y");
                for ($i = $current_year; $i >= $current_year - 5; $i--): 
                ?>
                <option value="<?php echo $i; ?>" <?php if($student['admission_year'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" value="<?php echo $student['username']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password (leave blank to keep current):</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Update Student</button>
            <a href="manage_students.php" class="btn back-btn">Cancel</a>
        </div>
    </form>
</div>

<?php include_once("../includes/footer.php"); ?>