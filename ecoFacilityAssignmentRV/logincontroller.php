<?php
session_start(); //start a session to manage users and data
require_once('sessioncontroller.php'); // Manage session timeout
require_once('Models/Database.php'); //  The database connection file

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);// Get the username from the login form.
    $password = trim($_POST['password']); // Get the password from the login form.

    $pdo = Database::getInstance()->getdbConnection();

    $stmt = $pdo->prepare("SELECT * FROM ecoUser WHERE username = :username");
    $stmt->execute(['username' => $username]); // Run the query with the provided username.
    $user = $stmt->fetch(PDO::FETCH_ASSOC); //It fetches the username

    if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true); // new session ID after login
    // Set session variables
        // Set session variables
        $_SESSION['login'] = $username;
        $_SESSION['userType'] = $user['userType'];  // Store usertype in session

        header("Location: index.php"); // Redirect after successful login
        exit;
    } else {
        echo "Invalid username or password.";
    }
}

// check the logout button once pressed end session, log out
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logoutbutton'])) {
    session_destroy(); // Destroy the session
    header("Location: page1.php"); // Redirect to the login page
    exit;
}
