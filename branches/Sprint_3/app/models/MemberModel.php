<?php

define('NEW_MEMBER_QUERY', "INSERT INTO member (partecipationRequestId, teamId) " .
    "VALUES (:partecipationRequestId, :teamId)");

class MemberModel {
    private $database;

    /**
     * MemberModel constructor.
     */
    public function __construct()
    {
        $this->database = new Database();
    }

    public function createMember(MemberDTO $memberDTO) {
        $this->database->query(NEW_MEMBER_QUERY);
        $this->database->bind("partecipationRequestId", $memberDTO->getPartecipationRequestId());
        $this->database->bind("teamId", $memberDTO->getTeamId());
        $this->database->execute();
    }
}

class MemberDTO {
    private $partecipationRequestId;
    private $teamId;

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
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * @param mixed $teamId
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;
    }
}