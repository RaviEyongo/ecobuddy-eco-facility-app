<?php
class EcoUserData{

    //ecoUserData properties
    private $userID;
    private $username;
    private $password;
    private $userType;

    //intializes ecoUserData properties
    public function __construct($dbRow){
        $this->userID = $dbRow['id'];
        $this->username = $dbRow['username'];
        $this->password = $dbRow['password'];
        $this->userType = $dbRow['userType'];
    }

    // returns UserID
    public function getUserID(){
        return $this->userID;
    }

    //returns Username
    public function getUsername(){
        return $this->username;
    }

    //returns Password
    public function getPassword(){
        return $this->password;
    }

    //return User Type
    public function getUserType(){
        return $this->userType;
    }

}