<?php
// Start session
session_start();

include_once("../includes/config.php");
include_once("../includes/functions.php");

check_login("faculty");

// Getting faculty info
$faculty_id = $_SESSION['faculty'];
$faculty_department = $_SESSION['faculty_department'];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = sanitize($_POST['title']);
    $message = sanitize($_POST['message']);
    $date = date("Y-m-d H:i:s");
    
    // Insert notification
    $sql = "INSERT INTO notifications (faculty_id, department, title, message, date) 
            VALUES ($faculty_id, '$faculty_department', '$title', '$message', '$date')";
    
    if (mysqli_query($conn, $sql)) {
        $success = "Notification sent successfully";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Get recent notifications by this faculty
$sql = "SELECT * FROM notifications WHERE faculty_id = $faculty_id ORDER BY date DESC LIMIT 5";
$result = mysqli_query($conn, $sql);
?>
<?php include_once("../includes/header.php"); ?>

<h2>Send Notification</h2>

<?php if (isset($success)): ?>
<div class="message success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="message error"><?php echo $error; ?></div>
<?php endif; ?>

<div class="form-container" style="max-width: 600px;">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="title">Notification Title:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
        </div>
        
        <div class="form-group">
            <p><strong>Department:</strong> <?php echo $faculty_department; ?></p>
            <p><small>This notification will be visible to all students in your department.</small></p>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Send Notification</button>
        </div>
    </form>
</div>

<h3 style="margin-top: 30px;">Recent Notifications</h3>

<?php if (mysqli_num_rows($result) > 0): ?>
<table class="data-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['message']; ?></td>
            <td><?php echo date("d M Y H:i", strtotime($row['date'])); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>No notifications sent yet.</p>
<?php endif; ?>

<?php include_once("../includes/footer.php"); ?>