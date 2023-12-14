<?php
// Start session (if not already started)
session_start();

$configFilePath = '/data/cloudflare-ip-checker/config.json';
$loginError = ''; // Initialize the login error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedEmail = $_POST['email'];
    $postedPassword = $_POST['password'];

    $configData = file_get_contents($configFilePath);
    $configJson = json_decode($configData, true);

    $dashboardUser = $configJson['DASHBOARD_USER'];
    $dashboardPassword = $configJson['DASHBOARD_PASSWORD'];

    if ($postedEmail === $dashboardUser && $postedPassword === $dashboardPassword) {
        $_SESSION['authenticated'] = true; // Set the authentication flag
        $_SESSION['username'] = $dashboardUser; // Set the username from DASHBOARD_USER
        header('Location: /dashboard'); // Redirect to dashboard on successful login
        exit();
    } else {
        $loginError = 'Invalid email or password';
    }
}

// Handle logout
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset();    // Unset all session variables
    session_destroy();  // Destroy the session
    header('Location: /'); // Redirect to sign-in page
    exit();
}
?>
