<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

// Check if admin is logged in
check_login("admin");

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
    $password = sanitize($_POST['password']); // In real system, hash this password
    
    // Insert new student
    $sql = "INSERT INTO students (name, email, phone, department, roll_number, semester, admission_year, username, password) 
            VALUES ('$name', '$email', '$phone', '$department', '$roll_number', $semester, $admission_year, '$username', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        redirect("manage_students.php", "Student added successfully", "success");
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<?php include_once("../includes/header.php"); ?>

<h2>Add New Student</h2>

<?php if (isset($error)): ?>
<div class="message error"><?php echo $error; ?></div>
<?php endif; ?>

<div class="form-container" style="max-width: 600px;">
    <form id="userForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="department">Department:</label>
            <select id="department" name="department" class="form-control" required>
                <option value="CSE">Computer Science (CSE)</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="roll_number">Roll Number:</label>
            <input type="text" id="roll_number" name="roll_number" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="semester">Semester:</label>
            <select id="semester" name="semester" class="form-control" required>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
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
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Add Student</button>
            <a href="manage_students.php" class="btn back-btn">Cancel</a>
        </div>
    </form>
</div>

<?php include_once("../includes/footer.php"); ?>