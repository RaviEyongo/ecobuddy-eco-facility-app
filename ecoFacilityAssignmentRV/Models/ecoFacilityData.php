<?php
class ecoFacilityData {

    // Define facility properties
    protected $id, $title, $category, $description, $houseNumber, $streetName, $county, $town, $postcode, $longitude, $latitude, $contributor, $status;
    private $pdo;

    //Constructor initializes properties from the database

    // binding user inputs into the variable to put into database
    public function __construct($dbRow){
        $this->id = $dbRow['id'];
        $this->title = $dbRow['title'];
        $this->category = $dbRow['category'];
        $this->description = $dbRow['description'];
        $this->houseNumber = $dbRow['houseNumber'];
        $this->streetName = $dbRow['streetName'];
        $this->county = $dbRow['county'];
        $this->town = $dbRow['town'];
        $this->postcode = $dbRow['postcode'];
        $this->longitude = $dbRow['lng'];
        $this->latitude = $dbRow['lat'];
        $this->contributor = $dbRow['contributor'];
        $this->status = $dbRow['status'];

    }

    // Method to insert a new facility into the database
    public function insertNewEcoFacility($formData) {
        try {
            // Prepare the SQL query
            $stmt = $this->pdo->prepare(
                "INSERT INTO ecoFacilities (
                    title, category, description, houseNumber, streetName, county, town, postcode, lng, lat, contributor, status
                ) VALUES (
                    :title, :category, :description, :houseNumber, :streetName, :county, :town, :postcode, :lng, :lat, :contributor, :status
                )"
            );

            // binding user inputs into the variable to put into database
            $stmt->bindParam(':title', $formData['title']);
            $stmt->bindParam(':category', $formData['category']);
            $stmt->bindParam(':description', $formData['description']);
            $stmt->bindParam(':houseNumber', $formData['houseNumber']);
            $stmt->bindParam(':streetName', $formData['streetName']);
            $stmt->bindParam(':county', $formData['county']);
            $stmt->bindParam(':town', $formData['town']);
            $stmt->bindParam(':postcode', $formData['postcode']);
            $stmt->bindParam(':lng', $formData['lng']);
            $stmt->bindParam(':lat', $formData['lat']);
            $stmt->bindParam(':contributor', $formData['contributor']);
            $stmt->bindParam(':status', $formData['status']);

            // Execute the query
            $stmt->execute();

            return "Facility added successfully!";
        } catch (PDOException $e) {
            // If an error occurs, return the error message
            return "Error: " . $e->getMessage();
        }
    }
    //getter to return the ecoFacility ID
    public function getID() {
        return $this->id;
    }


    //getter returns ecoFacility title
    public function getTitle() {
        return $this->title;
    }

    //getter returns ecoFacility category
    public function getCategory() {
        return $this->category;
    }

    //getter returns ecoFacility description
    public function getDescription() {
        return $this->description;
    }

    //getter returns ecoFacility house number
    public function getHouseNumber() {
        return $this->houseNumber;
    }

    //getter returns ecofacility street name
    public function getStreetName() {
        return $this->streetName;
    }


    //getter returns ecofacility county
    public function getCounty() {
        return $this->county;
    }

    //getter returns ecofacility town
    public function getTown() {
        return $this->town;
    }

    //getter returns ecofacility postcode
    public function getPostcode() {
        return $this->postcode;
    }

    //getter returns ecofacility longitude
    public function getLongitude() {
        return $this->longitude;
    }

    //getter returns ecofacility latitude
    public function getLatitude() {
        return $this->latitude;
    }

    //getter returns ecofacility contributor
    public function getContributor() {
        return $this->contributor;
    }

    //getter returns ecofacility status
    public function getStatus(){
        return $this->status;
    }




}