<?php
// Start session (if not already started)
session_start();

// Check if user is authenticated (based on your authentication logic)
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: /'); // Redirect to sign-in page
    exit();
}

// Handle logout
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset();    // Unset all session variables
    session_destroy();  // Destroy the session
    header('Location: /'); // Redirect to sign-in page
    exit();
}
?>
