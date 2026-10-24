<?php
// Check if a session has already started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session only if no session is active
}

//  session timeout
define('SESSION_TIMEOUT', 900); // 900 seconds = 15 minutes

// Check if the user is logged in
if (isset($_SESSION['login'])) {
    //check if the last recorded activity time exists and if it's been more than 15 minutes
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > SESSION_TIMEOUT) {
        // If it's been too long, inactivity, log them out
        session_unset();  // Unset session variables
        session_destroy(); // Destroy the session
        header("Location: page1.php?timeout=true"); // Redirect to login page with timeout message
        exit;
    }
    // If the session hasn't timed out, update last activity time to now
    $_SESSION['LAST_ACTIVITY'] = time();
}