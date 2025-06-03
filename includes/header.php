<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get current file name
$current_page = basename($_SERVER['PHP_SELF']);

// Set title based on current page
$title = "CampusOne";
if (strpos($current_page, "admin") !== false) {
    $title = "Admin Panel - " . $title;
} elseif (strpos($current_page, "faculty") !== false) {
    $title = "Faculty Panel - " . $title;
} elseif (strpos($current_page, "student") !== false) {
    $title = "Student Panel - " . $title;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?php echo $title; ?></h1>
            <?php if (isset($_SESSION['admin']) || isset($_SESSION['faculty']) || isset($_SESSION['student'])): ?>
            <div class="header-buttons">
                <?php if ($current_page != "dashboard.php"): ?>
                <a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>
                <?php endif; ?>
                <a href="logout.php" class="btn logout-btn">Logout</a>
            </div>
            <?php endif; ?>
        </header>
        
        <?php display_message(); ?>
        
        <main>