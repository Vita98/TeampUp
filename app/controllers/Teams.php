<?php
define('IDEA_DTO','ideaDTO');
define('NEW_TEAM_VIEW','/teams/newTeam');
define('TEAM_MANAGE_VIEW','/teams/manageTeam');
define('TEAM_SHOW_MY_TEAMS', '/teams/showMyTeams');
define('TEAM_LEAVE', '/teams/leaveTeam');

define('ERRORS', 'errors');
define('CHECKED', 'checked');
define('EDITMODE', 'editMode');
define('TEAM_MESSAGE','teamMessage');

define('DESCRIPT_FIELD', 'description');
define('TITLE_FIELD', 'title');
define('TEAM_ID','teamid');
define('PARTICIPANT_REQUEST_ID', 'participantRequestId');
define('NUMBER_OF_MEMBER','numberOfMember');
define('TEAM','team');
define('ROLE','role');
define('MEMBER','member');
define('OWNER','owner');
define('TEAM_LIST_KEY', 'teamDTOList');

define('REALIZATION_PHASE','realizationPhase');

class Teams extends Controller{

    private $teamModel;
    private $realizationPhaseModel;
    private $ideaModel;
    private $memberModel;

    public function __construct()
    {
        $this->teamModel = $this->model(TeamModel::class);
        $this->realizationPhaseModel = $this->model(RealizationPhaseModel::class);
        $this->ideaModel = $this->model(IdeaModel::class);
        $this->memberModel = $this->model(MemberModel::class);
    }

    public function newTeam($id = null){
        if (!isLoggedIn()) {
            redirect("");
        }


        $teamDTO = new TeamDTO();
        if($_SERVER[REQUEST_METHOD_KEY] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if($_SESSION[USER_ID] != $this->ideaModel->getIdeaById($_POST[IDEA_ID])->getOwnerId() || !$this->ideaModel->getIdeaById($_POST[IDEA_ID])->getOwnerId()){
                redirect("");
            }

            $data = null;
            $data[IDEA_ID]=$_POST[IDEA_ID];
            $data[CHECKED] = [];
            $data[ERRORS] = [TITLE_FIELD => ""];
            $teamDTO->setName(trim($_POST[TITLE_FIELD]));
            $data[TEAM_DTO] = $teamDTO;

            if (empty($data[TEAM_DTO]->getName())) {
                $data[ERRORS][TITLE_FIELD] = 'Inserisci un nome valido';
            }

            //check if errors are present
            if (empty($data[ERRORS][TITLE_FIELD])) {
                $teamDTO->setIdeaId($data[IDEA_ID]);
                $team_id = $this->teamModel->createTeam($teamDTO);
                if($team_id){
                    foreach ($_POST[REALIZATION_PHASE] as $realizationPhase) {

                        $this->realizationPhaseModel->assTeamRealizationPhase($team_id, $realizationPhase);
                    }
                    flash(TEAM_MESSAGE,'Il team è stato aggiunto correttamente');
                    redirect('teams/manageTeam/' . $data[IDEA_ID]);
                } else{
                    die('Sembra che qualcosa sia andato storto...');
                }
            } else{
                $data[REALIZATION_PHASE] = $this->realizationPhaseModel->getRealizationPhaseByIdeaForTeam($data[IDEA_ID]);

                if (isset($_POST[REALIZATION_PHASE])) {
                    foreach ($_POST[REALIZATION_PHASE] as $checkedRealizationPhase) {
                        array_push($data[CHECKED], $checkedRealizationPhase);
                    }
                }
                $this->view(NEW_TEAM_VIEW, $data);
            }

        } else {
           if($_SESSION[USER_ID] != $this->ideaModel->getIdeaById($id)->getOwnerId() || !$this->ideaModel->getIdeaById($id)){
                redirect("");
            }


            $data = [
                ERRORS => [TITLE_FIELD => "", DESCRIPT_FIELD => "", CHECKED => ""],
                CHECKED => [],
                TEAM_DTO => $teamDTO,
                REALIZATION_PHASE => $this->realizationPhaseModel->getRealizationPhaseByIdeaForTeam($id),
                IDEA_ID => $id
            ];

            $this->view(NEW_TEAM_VIEW,$data);
        }
    }
    
    public function manageTeam($id = null ){

        if (!isLoggedIn()) {
            redirect("");
        }


        if (!$this->ideaModel->getIdeaById($id)) {
            redirect("");
        }

        if(!$this->teamModel->isMember($id,$_SESSION[USER_ID]) && $this->ideaModel->getIdeaById($id)->getOwnerId() != $_SESSION[USER_ID]) {
            redirect("");
        }

        if($this->teamModel->isMember($id,$_SESSION[USER_ID])){
             $data[ROLE] = MEMBER;
        }else{
            $data[ROLE] = OWNER;
        }

        $data[IDEA_DTO] = $this->ideaModel->getIdeaById($id);
        $data[TEAM_DTO] = $this->teamModel->getTeamsByIdeaId($id);

        foreach ($data[TEAM_DTO] as $team){
            $team->setNumberOfMember( $this->teamModel->countMemberByTeam($team->getId()));
        }

        $this->view(TEAM_MANAGE_VIEW,$data);

    }

    public function showMyTeams() {
        if(!isLoggedIn()) {
            redirect("");
        }

        $data = [
            TEAM_LIST_KEY => $this->teamModel->getMyTeams($_SESSION[USER_ID])
        ];

        $this->view(TEAM_SHOW_MY_TEAMS, $data);
    }

    public function leaveTeam($teamId, $participantRequestId) {
        if(!isLoggedIn()) {
            redirect("");
        }

        $this->view(TEAM_LEAVE, [
            TEAM_ID => $teamId,
            PARTICIPANT_REQUEST_ID => $participantRequestId
        ]);
    }

    public function doLeaveTeam($teamId, $participantRequestId) {
        $this->memberModel->leaveTeam($participantRequestId, $teamId);

        flash(TEAM_MESSAGE, "Sei uscito dal Team correttemente");

        redirect(TEAM_SHOW_MY_TEAMS);
    }
}
