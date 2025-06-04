<?php
// Start session
session_start();

// Check if admin is already logged in
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
}

// database connection
include_once("../includes/config.php");
include_once("../includes/functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);
    
    // Admin password prestored
    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        redirect("dashboard.php", "Welcome to Admin Panel", "success");
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Student Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Login</h1>
            <div class="header-buttons">
                <a href="../index.php" class="btn back-btn">Back to Home</a>
            </div>
        </header>
        
        <main>
            <div class="form-container">
                <h2>Admin Login</h2>
                
                <?php if (isset($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn">Login</button>
                    </div>
                </form>
            </div>
        </main>
        
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Student Management System</p>
        </footer>
    </div>
    
    <script src="../assets/js/main.js"></script>
</body>
</html>