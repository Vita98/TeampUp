<?php
define('CREATE_TEAM_QUERY','INSERT INTO Team(name,ideaId) VALUES (:name, :id)');
define('GET_TEAMS_BY_IDEA_QUERY','SELECT * FROM team WHERE ideaId = :id ');
define('COUNT_MEMBER_BY_TEAM_QUERY','SELECT count(partecipationRequestId) FROM member WHERE teamId = :id ');
define('IS_MEMBER_QUERY','SELECT * FROM member, partecipationRequest, team WHERE member.partecipationRequestId = partecipationRequest.partecipationRequestId AND team.id = member.teamId AND partecipationRequest.userId = :id AND isPending = false AND team.ideaId = :ideaId');
define(
    "GET_BY_IDEA_ID_AND_PARTICIPANT_REQUEST_ID",
    "SELECT * ".
    "FROM team ".
    "WHERE team.id not in ( ".
        "SELECT team.id ".
        "FROM team ".
        "JOIN member on team.id = member.teamId ".
        "WHERE team.ideaId = :ideaId and member.partecipationRequestId = :participationRequestId ".
    ") and team.ideaId = :ideaId"
);
define(
    "GET_MY_TEAMS",
    "select team.*, partecipationRequest.partecipationRequestId AS partecipationRequestId ".
    "from user ".
    "join partecipationRequest on user.id = partecipationRequest.userId ".
    "join member on partecipationRequest.partecipationRequestId = member.partecipationRequestId ".
    "join team on member.teamId = team.id ".
    "where user.id = :userId"
);

define(
    "GET_MY_TEAMS_BY_IDEA",
    "select team.*, partecipationRequest.partecipationRequestId AS partecipationRequestId ".
    "from user ".
    "join partecipationRequest on user.id = partecipationRequest.userId ".
    "join member on partecipationRequest.partecipationRequestId = member.partecipationRequestId ".
    "join team on member.teamId = team.id ".
    "where user.id = :userId AND team.ideaId=:ideaId"
);
define('REMOVE_MEMBER_QUERY','REMOVE FROM member WHERE partecipationRequestId = :partecipationRequestId');

define('NEW_MEMBER_QUERY', "INSERT INTO member (partecipationRequestId, teamId) " .
    "VALUES (:partecipationRequestId, :teamId)");
define(
    'DELETE_MEMBER_FOR_LEAVE_TEAM',
    'DELETE FROM member WHERE member.partecipationRequestId = :participationRequestId AND member.teamId = :teamId'
);

class TeamModel{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function createTeam(TeamDTO $teamDTO){
        $this->database->query(CREATE_TEAM_QUERY);
        $this->database->bind(':name',$teamDTO->getName());
        $this->database->bind(':id',$teamDTO->getIdeaId());

       if( $this->database->execute()){
        return $this->database->lastInsertId();
       }
       return false;
    }

    public function getTeamsByIdeaId($id){
        $this->database->query(GET_TEAMS_BY_IDEA_QUERY);
        $this->database->bind(':id', $id);

        return $this->database->classesFromResultSet(TeamDTO::class);
    }

    public function countMemberByTeam($id){
        $this->database->query(COUNT_MEMBER_BY_TEAM_QUERY);
        $this->database->bind(':id',$id);
        $this->database->execute();

        return $this->database->fetchColumn();

    }

    public function isMember($id,$ideaId){
        $this->database->query(IS_MEMBER_QUERY);
        $this->database->bind(':id',$id);
        $this->database->bind(':ideaId',$ideaId);

        $this->database->single();

        // Check row
        return ($this->database->rowCount() > 0);
    }

    public function getByIdeaIdAndParticipantRequestId($ideaId, $participationRequestId) {
        $this->database->query(GET_BY_IDEA_ID_AND_PARTICIPANT_REQUEST_ID);
        $this->database->bind(":ideaId", $ideaId);
        $this->database->bind(":participationRequestId", $participationRequestId);

        return $this->database->classesFromResultSet(TeamDTO::class);
    }

    public function getMyTeams($userId) {
        $this->database->query(GET_MY_TEAMS);
        $this->database->bind(":userId", $userId);
        return $this->database->classesFromResultSet(TeamParticipationRequestDTO::class);
    }

    public function getMyTeamsByIdeaId($userId,$ideaId) {
        $this->database->query(GET_MY_TEAMS_BY_IDEA);
        $this->database->bind(":userId", $userId);
        $this->database->bind(":ideaId", $ideaId);
        return $this->database->classesFromResultSet(TeamParticipationRequestDTO::class);
    }

    public function newMember(MemberDTO $memberDTO) {
        $this->database->query(NEW_MEMBER_QUERY);
        $this->database->bind(":partecipationRequestId", $memberDTO->getPartecipationRequestId());
        $this->database->bind(":teamId", $memberDTO->getTeamId());
        $this->database->execute();
    }

    public function deleteMember($participationRequestId, $teamId) {
        $this->database->query(DELETE_MEMBER_FOR_LEAVE_TEAM);
        $this->database->bind(":participationRequestId", $participationRequestId);
        $this->database->bind(":teamId", $teamId);
        $this->database->execute();
    }


}

class TeamDTO
{
    protected $id;
    protected $name;
    protected $ideaId;
    protected $numberOfMember;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getNumberOfMember()
    {
        return $this->numberOfMember;
    }

    /**
     * @param mixed $numberOfMember
     */
    public function setNumberOfMember($numberOfMember)
    {
        $this->numberOfMember = $numberOfMember;
    }
}

class TeamParticipationRequestDTO extends TeamDTO{
    protected $partecipationRequestId;

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