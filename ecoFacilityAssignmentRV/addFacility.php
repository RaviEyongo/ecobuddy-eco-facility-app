<?php

require_once('sessioncontroller.php');
require_once('Models/ecoFacilityDataSet.php');

// Check if the user is logged in and is an admin (userType 1)
if (!isset($_SESSION['userType']) || $_SESSION['userType'] != 1) {
    header('Location: index.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
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
        'contributor' => $_SESSION['login'],
        'status' => $_SESSION['status']
    ];

    // Create an instance of the EcoFacilityDataSet model
    $ecoFacilityDataSet = new EcoFacilityDataSet();

    // Check for duplicate title
    if (!$ecoFacilityDataSet->isTitleUnique($formData['title'])) {
        // Title is not unique; display an error message
        $errorMessage = "Error: Another eco-facility with the same title exists. Please choose a different title.";
    } else {
        // Title is unique
        $ecoFacilityDataSet->addEcoFacility($formData); // use the addEcoFacility method

        // Redirect to index page
        header('Location: index.php');
        exit;
    }
}

// Pass page title and any error message to the view
$view = new stdClass();
$view->pageTitle = "Add Eco-Facility"; // Page is called eco-facility
$view->errorMessage = isset($errorMessage) ? $errorMessage : null;

require_once('Views/addFacility.phtml');