<?php

require_once('sessioncontroller.php');
require_once('Models/ecoFacilityDataSet.php');

// Check if the user is logged in and is an admin (userType 1)
if (!isset($_SESSION['userType']) || $_SESSION['userType'] != 1) {
    header('Location: index.php');
    exit;
}

// Check if the facility ID is provided in the URL
if (!isset($_GET['id'])) {
    header('Location: index.php'); // Redirect if no ID is provided
    exit;
}

$id = (int)$_GET['id']; // Get the ID from the URL

// Get the facility details
$ecoFacilityDataSet = new EcoFacilityDataSet();
$facility = $ecoFacilityDataSet->fetchEcoFacility($id);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'id' => $id,
        'title' => $_POST['title'],
        'category' => $_POST['category'],
        'description' => $_POST['description'],
        'houseNumber' => $_POST['houseNumber'],
        'streetName' => $_POST['streetName'],
        'county' => $_POST['county'],
        'town' => $_POST['town'],
        'postcode' => $_POST['postcode'],
        'longitude' => $_POST['longitude'],
        'latitude' => $_POST['latitude'],
        'status' => $_POST['status']
    ];

    // Check for duplicate title (except the current record being edited)
    if (!$ecoFacilityDataSet->isTitleUnique($formData['title'], $id)) {
        // Title is not unique so display an error message
        $errorMessage = "Error: Another eco-facility with the same title exists. Please choose a different title.";
    } else {
        // Title is unique so proceed with update
        $ecoFacilityDataSet->updateEcoFacility($id, $formData); // Update method
        header('Location: index.php'); // Redirect on success
        exit;
    }
}

// Pass data to the view
$view = new stdClass();
$view->pageTitle = "Edit Eco-Facility";
$view->facility = $facility;
$view->errorMessage = isset($errorMessage) ? $errorMessage : null;

require_once('Views/editFacility.phtml');
?>