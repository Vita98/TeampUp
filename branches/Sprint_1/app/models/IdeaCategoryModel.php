<?php

define("INSERT_CATEGORYIDEA", "INSERT INTO ideacategoryassociation (idea_id, ideaCategoryModel_id) VALUES (:ideaId, :categoryId)");
define("GET_CATEGORYBYIDEA", "SELECT id,description FROM ideacategoryassociation,ideacategory WHERE ideacategoryassociation.ideaCategoryModel_id = ideacategory.id AND idea_id = :ideaId  ");
class IdeaCategoryModel{
    private $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function getAll(){
        $this->database->query("SELECT * FROM ideacategory");
        return $this->database->classesFromResultSet(IdeaCategoryDTO::class);
    }

    public function assCategoryIdea($ideaId, $ideaCategoryId){
        $this->database->query(INSERT_CATEGORYIDEA);
        $this->database->bind(":ideaId", $ideaId);
        $this->database->bind(":categoryId", $ideaCategoryId);

        return $this->database->execute();
    }

    public function getCategoryByIdea($ideaId){
        $this->database->query(GET_CATEGORYBYIDEA);
        $this->database->bind(":ideaId", $ideaId);

        return $this->database->classesFromResultSet(IdeaCategoryDTO::class);
    }
}

class IdeaCategoryDTO{
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