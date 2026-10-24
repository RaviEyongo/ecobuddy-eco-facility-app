<?php
// Include the EcoFacilityController class
require_once('sessioncontroller.php'); // Include session handler to manage session timeout
require_once('EcoFacilityController.php');



//$ecoFacilityDataSet = new EcoFacilityDataSet();

//$searchQuery = $_GET['query'] ?? '';
//$searchCategory = $_GET['category'] ?? '';
//Get categories for dropdown
//$ecoCategories = $ecoCategoryDataSet->fetchCategories();

//$ecoFacilities = $ecoFacilityDataSet->searchEcoFacilities($searchQuery
// create an instance and call the method from the eco controller
$ecoFacilityController = new EcoFacilityController();
$ecoFacilityController->viewAll();

?>
