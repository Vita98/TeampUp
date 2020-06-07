<?php

class PartecipationRequestModel{
    protected $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function createPartecipationRequest($partecReqDTO){
        $this->database->query("INSERT INTO partecipationRequest (userId,ideaId,isPending,isUserRequesting) VALUES (:userId,:ideaId,:isPending,:isUserRequesting)");
        $this->database->bind(':userId', $partecReqDTO->getUserId());
        $this->database->bind(':ideaId', $partecReqDTO->getIdeaId());
        $this->database->bind(':isPending', $partecReqDTO->getIsPending());
        $this->database->bind(':isUserRequesting', $partecReqDTO->getIsUserRequesting());

        return $this->database->execute();
    }

    public function isUserAlreadyInvited($userId,$ideaId){
        $this->database->query("SELECT * FROM partecipationRequest WHERE userId=:userId AND ideaId=:ideaId AND isUserRequesting=false");
        $this->database->bind(':userId', $userId);
        $this->database->bind(':ideaId', $ideaId);

        $this->database->single();

        // Check row
        return ($this->database->rowCount() > 0);
    }

    public function hasAlreadyRequestedPartecipation($userId,$ideaId){
        $this->database->query("SELECT * FROM partecipationRequest WHERE userId=:userId AND ideaId=:ideaId AND isUserRequesting=true");
        $this->database->bind(':userId', $userId);
        $this->database->bind(':ideaId', $ideaId);

        $this->database->single();

        // Check row
        return ($this->database->rowCount() > 0);
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
    public function __construct($userId, $ideaId, $isPending, $isUserRequesting)
    {
        $this->userId = $userId;
        $this->ideaId = $ideaId;
        $this->isPending = $isPending;
        $this->isUserRequesting = $isUserRequesting;
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