<?php

header('Content-Type: application/json'); // Set the response type to JSON, so the browser knows we are returning data
require_once('Models/Database.php');
require_once('Models/ecoFacilityDataSet.php');

//Get the query and category from the URL parameters, if not they're empty
$query = $_GET['query'] ?? '';
$category = $_GET['category'] ?? '';
$limit = 10;

// Make sure the search query is 1-30 characters long and only has letters numbers and spaces
if (!preg_match('/^[a-zA-Z0-9\s]{1,30}$/', $query)) {
    //if not valid, return an empty JSON array and stop the script
    echo json_encode([]);
    exit;
}

//  Create an object
$dataSet = new EcoFacilityDataSet();

// Search for facilities based on the user's query and category
$facilities = $dataSet->searchEcoFacilities($query, $category);

// Format the data for the frontend to use
$jsonResults = array_map(function($facility) {
    return [
        'id' => htmlspecialchars($facility->getID()),
        'facilityName' => htmlspecialchars($facility->getTitle())
    ];
}, $facilities);

// Convert the PHP array into JSON and sent it back to the browser
echo json_encode($jsonResults);
?>