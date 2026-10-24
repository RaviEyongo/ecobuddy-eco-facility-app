<?php

require_once ('Database.php');
require_once ('ecoUserData.php');
class EcoUserDataSet {
    // EcoUserDataSet properties
    protected $_dbHandle, $_dbInstance;
    private $users = [];

    //initializes the EcoUserDataSet properties
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }



    // Load users from the database with SQL query
    public function fetchUsers() {
        $sqlQuery = "SELECT * FROM ecoUser";

        $stmt = $this->_dbHandle->prepare($sqlQuery);
        $stmt->execute();

        $users = [];
     // use while loops to fetch the userData from the database
        while ($row = $stmt->fetch()) {
            $users[] = new ecoUserData($row);
        }
        return $users;
    }
}
