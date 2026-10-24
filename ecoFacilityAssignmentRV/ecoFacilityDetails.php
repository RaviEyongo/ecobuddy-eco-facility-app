<?php
require_once('Models/ecoFacilityDataSet.php');
require_once('sessioncontroller.php'); // Manage session timeout

// Get the facility ID from the URL
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Invalid Facility ID!");
}

// Fetch the facility details using the EcoFacilityDataSet class
$dataSet = new EcoFacilityDataSet();
$facility = $dataSet->fetchEcoFacility($id);

if (!$facility) {
    die("Facility not found!");
}

// Include the view to display facility details
require('Views/ecoFacilityDetails.phtml');

// Include footer template
require('Views/template/footer.phtml');
?>