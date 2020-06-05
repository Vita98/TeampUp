<?php

define('NEW_IDEA_QUERY', "INSERT INTO idea (title, ownerId, description) " .
    "VALUES (:title, :ownerId, :description)");
define('GET_IDEA_BY_ID_QUERY', "SELECT * FROM idea WHERE id = :id");
define('GET_IDEA_BY_OWNER_ID_QUERY', "SELECT * FROM idea WHERE ownerId = :ownerId");
define('DELETE_BY_ID_QUERY', "DELETE FROM idea WHERE id = :id ");
define('UPDATE_IDEA', "UPDATE idea SET title=:title, description=:description, sponsorStartDate=:sponsorStartDate, sponsorCategoryid=:sponsorCategoryId WHERE id = :id");
define ("SEARCH_QUERY",
    " SELECT DISTINCT idea.* " .
    " FROM idea LEFT JOIN ideacategoryassociation ".
    " ON idea.id = ideacategoryassociation.idea_id LEFT JOIN feedback " .
    " ON idea.id = feedback.idea_id WHERE " .
    " (:ideaTitle IS NULL OR idea.title LIKE :ideaTitle) AND " .
    " (:cat1 IS NULL OR ideacategoryassociation.ideaCategoryModel_id IN ( ");
define ("SEARCH_QUERY_HAVING", " ) ) " .
    " GROUP BY idea.id HAVING " .
    " (:avgInnovativity IS NULL OR AVG(feedback.innovativityVote) >= :avgInnovativity) AND " .
    " (:avgCreativity IS NULL OR AVG(feedback.creativityVote) >= :avgCreativity) AND " .
    " (:avgVote IS NULL OR AVG( (feedback.creativityVote + feedback.innovativityVote) / 2 ) >= :avgVote)");

class IdeaModel{
    private $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function createIdea(IdeaDTO $ideaDTO) {
        $this->database->query(NEW_IDEA_QUERY);
        $this->database->bind(':title', $ideaDTO->getTitle());
        $this->database->bind(':ownerId', $ideaDTO->getOwnerId());
        $this->database->bind(':description', $ideaDTO->getDescription());

        if($this->database->execute()){
            return $this->database->lastInsertId();
        }
        return false;
    }

    public function getIdeaByID($id){
        $this->database->query(GET_IDEA_BY_ID_QUERY);
        $this->database->bind(":id", $id);
        return $this->database->classFromSingle(IdeaDTO::class);
    }

    public function getIdeasByOwnerId($id){
        $this->database->query(GET_IDEA_BY_OWNER_ID_QUERY);
        $this->database->bind(":ownerId", $id);

        return $this->database->classesFromResultSet(IDEADTO::class);
    }

    public function updateIdea(IdeaDTO $ideaDTO){
        $this->database->query(UPDATE_IDEA);
        $this->database->bind(":title", $ideaDTO->getTitle());
        $this->database->bind(":description", $ideaDTO->getDescription());
        $this->database->bind(":id", $ideaDTO->getId());
        $this->database->bind(":sponsorStartDate", $ideaDTO->getSponsorStartDate());
        $this->database->bind(":sponsorCategoryId", $ideaDTO->getSponsorCategoryId());
        $this->database->execute();
    }

    public function deleteIdea(IdeaDTO $ideaDTO) {
        $this->database->query(DELETE_BY_ID_QUERY);
        $this->database->bind(":id", $ideaDTO->getId());
        $this->database->execute();
    }

    public function getTopTen($voteType){
        $select_op = "";
        switch ($voteType){
            case INNOVATIVITY:
                $select_op = "AVG(feedback.innovativityVote) as avgInnovativity";
                break;
            case CREATIVITY:
                $select_op = "AVG(feedback.creativityVote) as avgCreativity";
                break;
            case BEST:
                $select_op = "AVG( (feedback.creativityVote + feedback.innovativityVote) / 2 ) as avgVote";
                break;
            default:
                return null;
        }

        $this->database->query("SELECT idea.*, ". $select_op ." FROM idea JOIN feedback ON idea.id=feedback.idea_id GROUP BY idea.id ORDER BY ".$voteType." DESC LIMIT 10");

        return $this->database->resultSet();
    }

    public function filteredSearch($title, $categories, $avgVote, $avgInnovativity, $avgCreativity){

        $catPlaceHolder = ":cat1";

        if($categories != null && count($categories) > 0){
            for($i = 2; $i <= count($categories); $i++){
                $catPlaceHolder = $catPlaceHolder.", :cat".$i;
            }
        }

        $query = SEARCH_QUERY . $catPlaceHolder . SEARCH_QUERY_HAVING;

        $this->database->query($query);

        $this->database->bind(":ideaTitle", $title );
        $this->database->bind(":avgVote", $avgVote );
        $this->database->bind(":avgInnovativity", $avgInnovativity );
        $this->database->bind(":avgCreativity", $avgCreativity );

        if($categories != null && count($categories) > 0){
            for($i = 1; $i <= count($categories); $i++){
                $this->database->bind(":cat".$i, $categories[$i-1]);
            }
        } else {
            $this->database->bind(":cat1", null);
        }

        return $this->database->classesFromResultSet(IdeaDTO::class);
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