<?php
require_once ('Models/EcoFacilityDataSet.php'); //EcoFacilityDataSet class
header('Content-Type: application/json'); // Set the response type to JSON

//Check if the request was made using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the facility ID and convert it to an integer
    $facilityID = intval($_POST['id']);
    $latitude = filter_var($_POST['latitude'], FILTER_VALIDATE_FLOAT); // Validate latitude to make sure they are valid float numbers
    $longitude = filter_var($_POST['longitude'], FILTER_VALIDATE_FLOAT); // Validate longitude to make sure they are valid float numbers

    //If any value is invalid, return an error message and stop
    if (!$facilityID || !$latitude || !$longitude) {
        echo json_encode(['success' => false, 'message' => 'Invalid input provided']);
        exit;
    }

    $ecoFacilityDataSet = new EcoFacilityDataSet();
    $result = $ecoFacilityDataSet->updateFacilityLocation($facilityID, $latitude, $longitude); // update the facility's location with new coordinates

    //Send back success status to frontend to confirm it worked
    echo json_encode(['success' => $result]);
}