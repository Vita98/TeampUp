<?php
define("GET_ALL_SPONSORCATEGORY", "SELECT id,description FROM sponsorcategory");

class SponsorCategoryModel {
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getAll() {
        $this->database->query(GET_ALL_SPONSORCATEGORY);
        return $this->database->classesFromResultSet(SponsorCategoryDTO::class);
    }
}

class SponsorCategoryDTO {
    private $id;
    private $description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}