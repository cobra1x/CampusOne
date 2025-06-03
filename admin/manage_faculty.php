<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

// Check if admin is logged in
check_login("admin");

// Delete faculty if requested
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM faculty WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        redirect("manage_faculty.php", "Faculty member deleted successfully", "success");
    } else {
        redirect("manage_faculty.php", "Error deleting faculty member: " . mysqli_error($conn), "error");
    }
}

// Get all faculty members
$sql = "SELECT * FROM faculty ORDER BY name";
$result = mysqli_query($conn, $sql);
?>
<?php include_once("../includes/header.php"); ?>

<h2>Manage Faculty</h2>

<div class="action-buttons" style="margin-bottom: 20px;">
    <a href="add_faculty.php" class="btn">Add New Faculty</a>
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
            <th>Education</th>
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
            <td><?php echo $row['education']; ?></td>
            <td class="action-buttons">
                <a href="edit_faculty.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                <a href="manage_faculty.php?delete=<?php echo $row['id']; ?>" class="btn delete-btn">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>No faculty members found.</p>
<?php endif; ?>

<?php include_once("../includes/footer.php"); ?>