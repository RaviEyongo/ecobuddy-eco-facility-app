<?php
require_once('Database.php');
require_once('ecoFacilityData.php');

class EcoFacilityDataSet {
    protected $_dbHandle;

    public function __construct() {
        $this->_dbHandle = Database::getInstance()->getdbConnection();
    }

    // Fetch all eco facilities with optional pagination
    public function fetchAllEcoFacilities($limit = null, $offset = null) {
        // Base query
        $sqlQuery = "SELECT * FROM ecoFacilities ORDER BY title";

        // Add pagination if limit/offset is provided
        if ($limit !== null && $offset !== null) {
            $sqlQuery .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->_dbHandle->prepare($sqlQuery);

        // Bind values for pagination
        if ($limit !== null && $offset !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();

        $dataSet = [];
        while ($row = $stmt->fetch()) {
            $dataSet[] = new ecoFacilityData($row);
        }
        return $dataSet;
    }

    // Fetch eco facilities with search and/or category filter, and pagination
    public function searchEcoFacilities($query = '', $category = '', $limit = 10, $offset = null) {
        $sqlQuery = "SELECT * FROM ecoFacilities WHERE 1"; // Base query (always true)

        $params = [];

        // Add filters dynamically
        if (!empty($query)) {
            $sqlQuery .= " AND (title LIKE :queryPartial)";
            $sqlQuery .= " ORDER BY CASE WHEN title LIKE :queryExact THEN 1 WHEN title LIKE :queryPartial THEN 2 ELSE 3 END";
            $params[':queryPartial'] = '%' . $query . '%'; // Matches anywhere in the title
            $params[':queryExact'] = $query . '%';         // Title starts with the letter

        }


        if (!empty($category)) {
            //filter results by the category
            $sqlQuery .= " AND category = :category";
            $params[':category'] = $category;
        }

        // Add pagination
        if ($limit !== null && $offset !== null) {
            $sqlQuery .= " LIMIT :limit OFFSET :offset";
        }


        $stmt = $this->_dbHandle->prepare($sqlQuery);

        // Bind dynamic parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        // Bind pagination
        if ($limit !== null && $offset !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }



        $stmt->execute();

        $dataSet = [];
        while ($row = $stmt->fetch()) {
            $dataSet[] = new ecoFacilityData($row);
        }
        return $dataSet;
    }

    // Total facility count for pagination
    public function getTotalRecords($query = '', $category = '') {
        $sqlQuery = "SELECT COUNT(*) AS total FROM ecoFacilities WHERE 1";

        $params = [];
        if (!empty($query)) {
            $sqlQuery .= " AND (title LIKE :query LIKE :query)";
            $params[':query'] = '%' . $query . '%';
        }

        if (!empty($category)) {
            $sqlQuery .= " AND category = :category";
            $params[':category'] = $category;
        }

        $stmt = $this->_dbHandle->prepare($sqlQuery);
        $stmt->execute($params);

        $result = $stmt->fetch();
        return $result['total'];
    }

    public function deleteEcoFacility($id)
    {
        $sql = "DELETE FROM ecoFacilities WHERE id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        //this deletes the ecofacility in the database where it's the id passed through

        try {
            // binding uthe statement into the variable to put into database
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            return $statement->execute(); // Returns true if success, if not, false
        } catch (PDOException $e) {
            // error log keeps track of potential errors
            error_log("Deletion Error: " . $e->getMessage());
            return false;
        }
    }


    public function fetchEcoFacility($id) {
        $sqlQuery = "SELECT * FROM ecoFacilities WHERE id = :id";
        // Prepares the query to prevent SQL injection
        $stmt = $this->_dbHandle->prepare($sqlQuery);
        $stmt->execute(['id' => $id]);
        // the result should be an array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //if the row is found it returns the ecofacility we searched for
        if ($row) {
            return new ecoFacilityData($row);
        }
        return null;
    }

    public function updateEcoFacility($id, $data) {
        //this is the sql query used to update an ecofacility and set the different attributes to what the user sets it as
        $sqlQuery = "UPDATE ecoFacilities 
                 SET title = :title, category = :category, description = :description, 
                     houseNumber = :houseNumber, streetName = :streetName, county = :county, 
                     town = :town, postcode = :postcode, lng = :longitude, lat = :latitude, status = :status
                 WHERE id = :id";

        // Prepares the query to prevent SQL injection
        $stmt = $this->_dbHandle->prepare($sqlQuery);
        //executes the update, sets the different attributes in the database to what the user inputs
        $stmt->execute([
            // binding user inputs into the variable to put into database
            ':title' => $data['title'],
            ':category' => $data['category'],
            ':description' => $data['description'],
            ':houseNumber' => $data['houseNumber'],
            ':streetName' => $data['streetName'],
            ':county' => $data['county'],
            ':town' => $data['town'],
            ':postcode' => $data['postcode'],
            ':longitude' => $data['longitude'],
            ':latitude' => $data['latitude'],
            ':status' => $data['status'],
            ':id' => $id
        ]);
    }

    //Makes sure that facilities have unique titles
    public function isTitleUnique($title, $excludeId = null) {
        $sqlQuery = "SELECT COUNT(*) AS count FROM ecoFacilities WHERE LOWER(title) = LOWER(:title)";

        if ($excludeId !== null) {
            $sqlQuery .= " AND id != :id"; // Exclude the current record by ID
        }

        $stmt = $this->_dbHandle->prepare($sqlQuery);

        // Bind parameters
        $params = [':title' => $title];
        if ($excludeId !== null) {
            $params[':id'] = $excludeId;
        }

        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] == 0; // Return true if the title is unique
    }

    public function addEcoFacility($formData) {
        $sql = "INSERT INTO ecoFacilities 
            (title, category, description, houseNumber, streetName, county, town, postcode, lng, lat, contributor, status) 
            VALUES 
            (:title, :category, :description, :houseNumber, :streetName, :county, :town, :postcode, :lng, :lat, :contributor, :status)";

        $stmt = $this->_dbHandle->prepare($sql);

        $stmt->execute([
            // binding user input into the variables to put into database
            ':title' => $formData['title'],
            ':category' => $formData['category'],
            ':description' => $formData['description'],
            ':houseNumber' => $formData['houseNumber'],
            ':streetName' => $formData['streetName'],
            ':county' => $formData['county'],
            ':town' => $formData['town'],
            ':postcode' => $formData['postcode'],
            ':lng' => $formData['longitude'],
            ':lat' => $formData['latitude'],
            ':contributor' => $formData['contributor'],
            ':status' => $formData['status']
        ]);
    }








}