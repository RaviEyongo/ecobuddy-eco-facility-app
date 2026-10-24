<?php
require_once ('Models/EcoFacilityDataSet.php');

// Tell the browser that the output will be in JSON format
header('Content-Type: application/json');

// Create a new instance of EcoFacilityDataSet to access facility data
$ecoFacilityDataSet = new EcoFacilityDataSet();

// Get all eco facilities from the database
$facilities = $ecoFacilityDataSet->fetchAllEcoFacilities();

// Create an empty array to hold the formatted facility data
$response = [];

// Loop through each facility and get specific information
foreach ($facilities as $facility) {
    $response[] = [
        'id' => $facility->getID(),
        'name' => $facility->getTitle(),
        'latitude' => $facility->getLatitude(),
        'longitude' => $facility->getLongitude()
    ];
}

// Convert the response array to JSON format and print it
echo json_encode($response);
