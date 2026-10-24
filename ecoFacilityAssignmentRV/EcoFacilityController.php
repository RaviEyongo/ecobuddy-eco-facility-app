<?php
require_once('Models/EcoFacilityDataSet.php');

class EcoFacilityController {
    public function viewAll() {
        require_once('sessioncontroller.php');

        $ecoFacilityDataSet = new EcoFacilityDataSet();

        // Pagination
        $facilitiesPerPage = 5;
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $facilitiesPerPage;

        // Search/filter logic
        $searchQuery = $_GET['query'] ?? '';
        $searchCategory = $_GET['category'] ?? '';

        // Fetch records and total count
        if (!empty($searchQuery) || !empty($searchCategory)) {
            //if the search query or category isn't empty, search for the ecoFacilities that meet the filter.
            $ecoFacilities = $ecoFacilityDataSet->searchEcoFacilities($searchQuery, $searchCategory, $facilitiesPerPage, $offset);
            $totalFacilities = $ecoFacilityDataSet->getTotalRecords($searchQuery, $searchCategory);
        } else {
            //show all ecoFacilities
            $ecoFacilities = $ecoFacilityDataSet->fetchAllEcoFacilities($facilitiesPerPage, $offset);
            $totalFacilities = $ecoFacilityDataSet->getTotalRecords();
        }

        $totalPages = ceil($totalFacilities / $facilitiesPerPage);

        // Add properties to the view
        $view = new stdClass();
        $view->ecoFacilities = $ecoFacilities;
        $view->currentPage = $currentPage;
        $view->totalPages = $totalPages;
        $view->pageTitle = 'Eco Facilities';

        require_once('Views/index.phtml'); // Load the view file
    }
}