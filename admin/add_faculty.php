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
    $education = sanitize($_POST['education']);
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']); // In real system, hash this password
    
    // Insert new faculty
    $sql = "INSERT INTO faculty (name, email, phone, department, education, username, password) 
            VALUES ('$name', '$email', '$phone', '$department', '$education', '$username', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        redirect("manage_faculty.php", "Faculty member added successfully", "success");
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<?php include_once("../includes/header.php"); ?>

<h2>Add New Faculty</h2>

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
            <label for="education">Education:</label>
            <input type="text" id="education" name="education" class="form-control" required>
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
            <button type="submit" class="btn">Add Faculty</button>
            <a href="manage_faculty.php" class="btn back-btn">Cancel</a>
        </div>
    </form>
</div>

<?php include_once("../includes/footer.php"); ?>