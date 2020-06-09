<?php
define('USER_ID_QUERY',':userId');
define('IDEA_ID_QUERY',':ideaId');
define(
    'FIND_PARTICIPANT_REQUESTS_IDEA',
    "SELECT partecipationRequest.* ".
    "FROM idea ".
    "JOIN partecipationrequest ON idea.id=partecipationrequest.ideaId ".
    "WHERE idea.id=:ideaId and partecipationrequest.isPending = 0"
);

class PartecipationRequestModel{
    protected $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function createPartecipationRequest($partecReqDTO){
        $this->database->query("INSERT INTO partecipationRequest (userId,ideaId,isPending,isUserRequesting) VALUES (:userId,:ideaId,:isPending,:isUserRequesting)");
        $this->database->bind(USER_ID_QUERY, $partecReqDTO->getUserId());
        $this->database->bind(IDEA_ID_QUERY, $partecReqDTO->getIdeaId());
        $this->database->bind(':isPending', $partecReqDTO->getIsPending());
        $this->database->bind(':isUserRequesting', $partecReqDTO->getIsUserRequesting());

        return $this->database->execute();
    }

    public function isUserAlreadyInvited($userId,$ideaId){
        $this->database->query("SELECT * FROM partecipationRequest WHERE userId=:userId AND ideaId=:ideaId");
        $this->database->bind(USER_ID_QUERY, $userId);
        $this->database->bind(IDEA_ID_QUERY, $ideaId);

        $this->database->single();

        // Check row
        return ($this->database->rowCount() > 0);
    }

    public function hasAlreadyRequestedPartecipation($userId,$ideaId){
        $this->database->query("SELECT * FROM partecipationRequest WHERE userId=:userId AND ideaId=:ideaId AND isUserRequesting=true");
        $this->database->bind(USER_ID_QUERY, $userId);
        $this->database->bind(IDEA_ID_QUERY, $ideaId);

        $this->database->single();

        // Check row
        return ($this->database->rowCount() > 0);
    }

    public function findParticipantRequestsIdea($ideaId) {
        $this->database->query(FIND_PARTICIPANT_REQUESTS_IDEA);
        $this->database->bind(":ideaId", $ideaId);

        return $this->database->classesFromResultSet(PartecipationRequestDTO::class);
    }

    public function getPartecipationRequestByUserId($userId){
        $this->database->query("SELECT * FROM partecipationRequest WHERE userId=:userId AND isPending=true");
        $this->database->bind(USER_ID_QUERY, $userId);

        return $this->database->classesFromResultSet(PartecipationRequestDTO::class);
    }

    public function getPartecipationRequestByIdeaId($ideaId){
        $this->database->query("SELECT * FROM partecipationRequest WHERE ideaId=:ideaId AND isPending=true");
        $this->database->bind(IDEA_ID_QUERY, $ideaId);

        return $this->database->classesFromResultSet(PartecipationRequestDTO::class);
    }

    public function getPartecipationRequestById($id){
        $this->database->query("SELECT * FROM partecipationRequest WHERE partecipationRequestId=:partReqId");
        $this->database->bind(':partReqId', $id);

        return $this->database->classFromSingle(PartecipationRequestDTO::class);
    }
}



class PartecipationRequestDTO {
    private $partecipationRequestId;
    private $userId;
    private $ideaId;
    private $isPending;
    private $isUserRequesting;

    /**
     * PartecipationRequestDTO constructor.
     * @param $userId
     * @param $ideaId
     * @param $isPending
     * @param $isUserRequesting
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getPartecipationRequestId()
    {
        return $this->partecipationRequestId;
    }

    /**
     * @param mixed $partecipationRequestId
     */
    public function setPartecipationRequestId($partecipationRequestId)
    {
        $this->partecipationRequestId = $partecipationRequestId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getIdeaId()
    {
        return $this->ideaId;
    }

    /**
     * @param mixed $ideaId
     */
    public function setIdeaId($ideaId)
    {
        $this->ideaId = $ideaId;
    }

    /**
     * @return mixed
     */
    public function getIsPending()
    {
        return $this->isPending;
    }

    /**
     * @param mixed $isPending
     */
    public function setIsPending($isPending)
    {
        $this->isPending = $isPending;
    }

    /**
     * @return mixed
     */
    public function getIsUserRequesting()
    {
        return $this->isUserRequesting;
    }

    /**
     * @param mixed $isUserRequesting
     */
    public function setIsUserRequesting($isUserRequesting)
    {
        $this->isUserRequesting = $isUserRequesting;
    }

}