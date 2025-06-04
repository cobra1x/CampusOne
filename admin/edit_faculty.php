<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

check_login("admin");

// Checking ID 
if (!isset($_GET['id'])) {
    redirect("manage_faculty.php", "Invalid faculty ID", "error");
}

$id = (int)$_GET['id'];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $department = sanitize($_POST['department']);
    $education = sanitize($_POST['education']);
    $username = sanitize($_POST['username']);
    
    $password_sql = "";
    if (!empty($_POST['password'])) {
        $password = sanitize($_POST['password']);
        $password_sql = ", password = '$password'";
    }
    
    // Updating faculty
    $sql = "UPDATE faculty SET 
            name = '$name', 
            email = '$email', 
            phone = '$phone', 
            department = '$department', 
            education = '$education', 
            username = '$username'
            $password_sql
            WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        redirect("manage_faculty.php", "Faculty member updated successfully", "success");
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
} else {
    // Get faculty data
    $sql = "SELECT * FROM faculty WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $faculty = mysqli_fetch_assoc($result);
    } else {
        redirect("manage_faculty.php", "Faculty member not found", "error");
    }
}
?>
<?php include_once("../includes/header.php"); ?>

<h2>Edit Faculty</h2>

<?php if (isset($error)): ?>
<div class="message error"><?php echo $error; ?></div>
<?php endif; ?>

<div class="form-container" style="max-width: 600px;">
    <form id="userForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $faculty['name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $faculty['email']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $faculty['phone']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="department">Department:</label>
            <select id="department" name="department" class="form-control" required>
                <option value="CSE" <?php if($faculty['department'] == 'CSE') echo 'selected'; ?>>Computer Science (CSE)</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="education">Education:</label>
            <input type="text" id="education" name="education" class="form-control" value="<?php echo $faculty['education']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" value="<?php echo $faculty['username']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password (leave blank to keep current):</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Update Faculty</button>
            <a href="manage_faculty.php" class="btn back-btn">Cancel</a>
        </div>
    </form>
</div>

<?php include_once("../includes/footer.php"); ?>