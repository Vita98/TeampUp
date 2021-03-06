<?php
define("IDEA_ID_PARAM", ":ideaId");
define("INSERT_CATEGORYIDEA", "INSERT INTO ideaCategoryAssociation (idea_id, ideaCategoryModel_id) VALUES (:ideaId, :categoryId)");
define("GET_CATEGORYBYIDEA", "SELECT id,description FROM ideaCategoryAssociation,ideaCategory WHERE ideaCategoryAssociation.ideaCategoryModel_id = ideaCategory.id AND idea_id = :ideaId  ");
define("DELETE_CATEGORIES_BY_IDEA", "DELETE FROM ideaCategoryAssociation WHERE idea_id = :ideaId");

class IdeaCategoryModel{
    private $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function getAll(){
        $this->database->query("SELECT * FROM ideaCategory");
        return $this->database->classesFromResultSet(IdeaCategoryDTO::class);
    }

    public function assCategoryIdea($ideaId, $ideaCategoryId){
        $this->database->query(INSERT_CATEGORYIDEA);
        $this->database->bind(IDEA_ID_PARAM, $ideaId);
        $this->database->bind(":categoryId", $ideaCategoryId);

        return $this->database->execute();
    }

    public function getCategoryByIdea($ideaId){
        $this->database->query(GET_CATEGORYBYIDEA);
        $this->database->bind(IDEA_ID_PARAM, $ideaId);

        return $this->database->classesFromResultSet(IdeaCategoryDTO::class);
    }

    public function deleteByIdeaId($ideaId){
        $this->database->query(DELETE_CATEGORIES_BY_IDEA);
        $this->database->bind(IDEA_ID_PARAM, $ideaId);
        return $this->database->execute();
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