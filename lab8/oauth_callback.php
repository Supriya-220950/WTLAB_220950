<?php
// SmartCare Lab 7: OAuth Callback Simulator
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'login') {
    // Simulate pulling data from Google/GitHub
    $_SESSION['oauth_user'] = [
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
        'provider' => 'Google',
        'avatar' => 'https://ui-avatars.com/api/?name=Jane+Smith&background=E8F5E9&color=4CAF50'
    ];
} elseif (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['oauth_user']);
}

header("Location: index.php");
exit;
?>
