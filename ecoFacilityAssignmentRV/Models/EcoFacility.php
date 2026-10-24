<?php

class EcoFacility
{
    private $id;
    private $title;
    private $category;
    private $description;
    private $houseNumber;
    private $streetName;
    private $town;
    private $county;
    private $postcode;
    private $longitude;
    private $latitude;
    private $contributor;

    private $status;

    // Getter for ID
    public function getID()
    {
        return $this->id;
    }

    // Getter for Title
    public function getTitle()
    {
        return $this->title;
    }

    // Getter for Category
    public function getCategory()
    {
        return $this->category;
    }

    // Getter for Description
    public function getDescription()
    {
        return $this->description;
    }

    // Getter for Address components
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    //Getter for Street Name
    public function getStreetName()
    {
        return $this->streetName;
    }

    //Getter for Town
    public function getTown()
    {
        return $this->town;
    }

    //Getter for County
    public function getCounty()
    {
        return $this->county;
    }

    //Getter for Postcode
    public function getPostcode()
    {
        return $this->postcode;
    }

    // Getter for Location components
    public function getLongitude()
    {
        return $this->longitude;
    }

    //Getter for Latitude
    public function getLatitude()
    {
        return $this->latitude;
    }

    // Getter for Contributor
    public function getContributor()
    {
        return $this->contributor;
    }

    public function getStatus(){
        return $this->status;
    }

}