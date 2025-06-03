<?php
// Common functions for the application

// Function to sanitize user input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to check if user is logged in
function check_login($role) {
    if (!isset($_SESSION[$role])) {
        header("Location: ../index.php");
        exit();
    }
}

// Function to redirect with message
function redirect($url, $message = "", $type = "info") {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
    header("Location: $url");
    exit();
}

// Function to display message
function display_message() {
    if (isset($_SESSION['message'])) {
        $type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info';
        echo '<div class="message ' . $type . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}
?>