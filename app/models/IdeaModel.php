<?php

define('NEW_IDEA_QUERY', "INSERT INTO idea (title, ownerId, description) " .
    "VALUES (:title, :ownerId, :description)");
define('FIND_IDEA_BY_ID_QUERY', "SELECT * FROM idea WHERE id = :id");

class IdeaModel{
    private $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function createIdea(IdeaDTO $ideaDTO) {
        $this->database->query(NEW_IDEA_QUERY);
        $this->database->bind(':title', $ideaDTO->getTitle());
        $this->database->bind(':ownerId', 1);
        $this->database->bind(':description', $ideaDTO->getDescription());

        if($this->database->execute()){
            return $this->database->lastInsertId();
        }
        return false;
    }

    public function findIdeaByID($id){
        $this->database->query(FIND_IDEA_BY_ID_QUERY);
        $this->database->bind(":id", $id);
        return $this->database->classFromSingle(IdeaDTO::class);
    }
}

class IdeaDTO {
    private $id;
    private $title;
    private $ownerId;
    private $description;
    private $creationDate;
    private $sponsorStartDate;
    private $sponsorCategoryId;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param mixed $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
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

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getSponsorStartDate()
    {
        return $this->sponsorStartDate;
    }

    /**
     * @param mixed $sponsorStartDate
     */
    public function setSponsorStartDate($sponsorStartDate)
    {
        $this->sponsorStartDate = $sponsorStartDate;
    }

    /**
     * @return mixed
     */
    public function getSponsorCategoryId()
    {
        return $this->sponsorCategoryId;
    }

    /**
     * @param mixed $sponsorCategoryId
     */
    public function setSponsorCategoryId($sponsorCategoryId)
    {
        $this->sponsorCategoryId = $sponsorCategoryId;
    }


}