<?php
// Start session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusOne</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>CampusOne</h1>
        </header>
        
        <main>
            <div class="welcome-text">
                <h2>Welcome to the CampusOne</h2>
                <p>Please select your role to login</p>
            </div>
            
            <div class="login-options">
                <div class="login-box">
                    <h3>Admin Login</h3>
                    <a href="admin/login.php" class="login-btn">Login as Admin</a>
                </div>
                
                <div class="login-box">
                    <h3>Faculty Login</h3>
                    <a href="faculty/login.php" class="login-btn">Login as Faculty</a>
                </div>
                
                <div class="login-box">
                    <h3>Student Login</h3>
                    <a href="student/login.php" class="login-btn">Login as Student</a>
                </div>
            </div>
        </main>
        
        <footer>
            <p>&copy; <?php echo date("Y"); ?> CampusOne</p>
        </footer>
    </div>
    
    <script src="assets/js/main.js"></script>
</body>
</html>