<?php

define('USERDTO_KEY','userDTO');
define('USER_LIST_KEY','userListDTO');
define('PARTICIPANT_REQUEST_LIST_KEY', 'participantRequestListDTO');
define('USER_COUNT_KEY', 'userCount');
define('USER_ABILITIES_KEY','userAbilities');
define('FIRST_NAME_KEY','firstName');
define('LAST_NAME_KEY','lastName');
define('TEAM_LIST_KEY', 'teamListDTO');
define('CHECKED', 'checked');
define('TEAM_CHECKED_NAME', 'teams');


class PartecipationRequests extends Controller {
    private $ideaModel;
    private $userModel;
    private $abilityModel;
    private $partecipationrequestModel;
    private $teamModel;
    private $memberModel;

    public function __construct(){
        $this->ideaModel = $this->model(IdeaModel::class);
        $this->userModel = $this->model(User::class);
        $this->abilityModel = $this->model(Ability::class);
        $this->partecipationrequestModel = $this->model(PartecipationRequestModel::class);
        $this->teamModel = $this->model(TeamModel::class);
        $this->memberModel = $this->model(MemberModel::class);
    }

    private function checkIdeaProprety($ideaId){
        if(!isLoggedIn() || $ideaId == null){
            return false;
        }

        //Checking if the request is made from the owner of the idea
        $idea = $this->ideaModel->getIdeaById($ideaId);
        if (!$idea){
            return false;
        }
        if($_SESSION[USER_ID] != $idea->getOwnerId()){
            return false;
        }

        return true;
    }

    /**
     * Function that load the view with all the possibilities about the partecipation request of an idea
     * @param null $ideaId
     */
    public function manageIdeaPartecipants($ideaId = null){
        if(!$this->checkIdeaProprety($ideaId)){
            redirect('');
        }

        $data[IDEA_ID] = $ideaId;
        $data[USER_LIST_KEY] = $this->userModel->getUserIdeaParticipants($ideaId);
        $data[PARTICIPANT_REQUEST_LIST_KEY] = $this->partecipationrequestModel->findParticipantRequestsIdea($ideaId);
        $data[USER_COUNT_KEY] = count($data[USER_LIST_KEY]);
        $this->view('partecipationRequests/manageIdeaPartecipants', $data);
    }

    public function addToTeam($participantRequestId, $ideaId) {
        if($_SERVER[REQUEST_METHOD_KEY] == 'POST') {
            if(isset($_POST[TEAM_CHECKED_NAME]) && is_array($_POST[TEAM_CHECKED_NAME])) {
                foreach ($_POST[TEAM_CHECKED_NAME] as $teamId) {
                    $member = new MemberDTO();
                    $member->setPartecipationRequestId($participantRequestId);
                    $member->setTeamId($teamId);
                    $this->memberModel->createMember($member);
                }
                flash("add_participant_to_teams", "OPERAZIONE COMPLETATA CON SUCCESSO");
                redirect('partecipationRequests/manageIdeaPartecipants/'.$ideaId);
            }
        }
        $data[TEAM_LIST_KEY] = $this->teamModel->getByIdeaIdAndParticipantRequestId($ideaId, $participantRequestId);
        $this->view('partecipationRequests/addToTeam', $data);
    }

    public function newPartecipationRequestChooser($ideaId = null){
        if(!$this->checkIdeaProprety($ideaId)){
            redirect('');
        }

        $data = [ USERDTO_KEY =>[], USER_ABILITIES_KEY => [], CHECKED => [], FIRST_NAME_KEY=> "", LAST_NAME_KEY=>"", IDEA_ID => $ideaId ,'post'=>false];
        $data[USER_ABILITIES_KEY] = $this->abilityModel->getAllAbilities();
        if($_SERVER[REQUEST_METHOD_KEY] == 'POST'){
            $data['post'] = true;
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data[CHECKED] = isset($_POST[CHECKED]) && !empty($_POST[CHECKED]) ? $_POST[CHECKED] : null;
            $data[FIRST_NAME_KEY] = isset($_POST[FIRST_NAME_KEY]) && !empty($_POST[FIRST_NAME_KEY]) ? $_POST[FIRST_NAME_KEY] : null;
            $data[LAST_NAME_KEY] = isset($_POST[LAST_NAME_KEY]) && !empty($_POST[LAST_NAME_KEY]) ? $_POST[LAST_NAME_KEY] : null;
            $data[USERDTO_KEY] = $this->userModel->getUsersByNameSurnameSkills("%".$_POST[FIRST_NAME_KEY]."%", "%".$_POST[LAST_NAME_KEY]."%", $data[CHECKED]);
        }

        //Rimuovo gli utenti gia invitati
        $count = 0;
        foreach ($data[USERDTO_KEY] as $user){
            if($this->partecipationrequestModel->isUserAlreadyInvited($user->getId(),$ideaId) || $_SESSION[USER_ID]==$user->getId()){
                unset($data[USERDTO_KEY][$count]);
            }
            $count++;
        }

        $this->view("partecipationRequests/newPartecipationRequestChooser", $data);
    }

    public function sendPartecipationRequest($ideaId = null, $typo=null, $userId = null){
        if(!isLoggedIn() || $ideaId == null){
            redirect('');
        }

        //Checking if the request is made from the owner of the idea
        $idea = $this->ideaModel->getIdeaById($ideaId);
        if (!$idea){
            redirect('');
        }

        if(!$typo){
            redirect('');
        }

        if($typo=='false'){
            //Vuol dire che il proprietario la sta inviando ad un utente
            //executing the query
            if(!$userId){
                redirect('');
            }

            $user = $this->userModel->getUserById($userId);
            if(!$user){
                redirect('');
            }

            if($_SESSION[USER_ID] != $idea->getOwnerId()){
                redirect('');
            }

            //Controllo se l'utente ha gia inviato un invito a quell'utente
            if($this->partecipationrequestModel->isUserAlreadyInvited($userId,$ideaId) || $_SESSION[USER_ID]==$userId){
                redirect('');
            }else{
                //Effettuo l'inserimento
                $partReq = new PartecipationRequestDTO($userId,$ideaId,true,false);
                if($this->partecipationrequestModel->createPartecipationRequest($partReq)){
                    flash('INVITE_CORRECTLY_SENT', 'Invito alla partecipazione correttamente inviato!');
                    redirect('partecipationRequests/manageIdeaPartecipants/'.$ideaId);
                }else{
                    die('Qualcosa è andato storto!');
                }


            }
        }elseif ($typo=='true'){
            //Sono qui se la richiesta la sta facendo l'utente all'idea
            //Effettuo l'inserimento
            $partReq = new PartecipationRequestDTO($_SESSION[USER_ID],$ideaId,true,true);
            if ($this->partecipationrequestModel->createPartecipationRequest($partReq)){
                flash('REQUEST_CORRECTLY_SENT', 'Richiesta di partecipazione correttamente inviata!');
                redirect('ideas/showIdea/'.$ideaId);
            }else{
                die('Qualcosa è andato storto!');
            }
        }else{
            redirect('');
        }




    }

}