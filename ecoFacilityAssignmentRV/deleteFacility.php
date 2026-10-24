<?php
require_once('sessioncontroller.php');
require_once('Models/EcoFacilityDataSet.php'); // Include the model to interact with eco facility data

if (!isset($_SESSION['userType']) || $_SESSION['userType'] != 1) {
    // Check if the user is logged in and is an admin (userType 1)
    die("Access Denied: You do not have permission to delete facilities.");
    // Stop the script if the user isn't an admin
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Check if the request is POST and the facility ID is provided in the request
    $id = intval($_POST['id']); // Ensure it's an integer
    $ecoFacilityDataSet = new EcoFacilityDataSet(); // Create an instance of the model to interact with

    if ($ecoFacilityDataSet->deleteEcoFacility($id)) {
        // Try deleting the facility with the given ID
        header("Location: index.php?success=Facility deleted!"); // Redirect to the index page with a success message
        exit; // Stop execution after redirect
    } else {
        header("Location: index.php?error=Failed to delete facility."); // Redirect to the index page with an error message
        exit; // Stop execution after redirect
    }
} else {
    die("Invalid Request: Facility ID not provided."); // Handle invalid requests
}