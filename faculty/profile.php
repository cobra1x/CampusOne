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

// Get faculty data
$sql = "SELECT * FROM faculty WHERE id = $faculty_id";
$result = mysqli_query($conn, $sql);
$faculty = mysqli_fetch_assoc($result);

// Process form submission if updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $phone = sanitize($_POST['phone']);
    $email = sanitize($_POST['email']);
    
    // Check if password should be updated
    $password_sql = "";
    if (!empty($_POST['password'])) {
        $password = sanitize($_POST['password']); // In real system, hash this password
        $password_sql = ", password = '$password'";
    }
    
    // Update faculty
    $sql = "UPDATE faculty SET 
            phone = '$phone', 
            email = '$email'
            $password_sql
            WHERE id = $faculty_id";
    
    if (mysqli_query($conn, $sql)) {
        // Refresh faculty data
        $sql = "SELECT * FROM faculty WHERE id = $faculty_id";
        $result = mysqli_query($conn, $sql);
        $faculty = mysqli_fetch_assoc($result);
        
        $success = "Profile updated successfully";
    } else {
        $error = "Error updating profile: " . mysqli_error($conn);
    }
}
?>
<?php include_once("../includes/header.php"); ?>

<h2>My Profile</h2>

<?php if (isset($success)): ?>
<div class="message success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="message error"><?php echo $error; ?></div>
<?php endif; ?>

<div class="profile-info">
    <h3>Personal Information</h3>
    
    <div class="profile-details">
        <p><strong>Name:</strong> <?php echo $faculty['name']; ?></p>
        <p><strong>Department:</strong> <?php echo $faculty['department']; ?></p>
        <p><strong>Education:</strong> <?php echo $faculty['education']; ?></p>
        <p><strong>Username:</strong> <?php echo $faculty['username']; ?></p>
    </div>
    
    <h3>Update Contact Information</h3>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $faculty['email']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $faculty['phone']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Change Password (leave blank to keep current):</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Update Profile</button>
        </div>
    </form>
</div>

<?php include_once("../includes/footer.php"); ?>