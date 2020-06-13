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

define('USERTYPE','user');
define('IDEATYPE','idea');
define('REQUESTS_DTO','REQUESTS_DTO');

define('REQUEST_CONTROL_TYPE','request_type');

define('REQUEST_RESPONSE_ACCEPT','ACCEPT');
define('REQUEST_RESPONSE_REJECT','REJECT');

define('SOMETHING_WENT_WRONG','Qualcosa è andato storto!');
define('FLASH_KEY_PARTECIPATION_REQU_RESPONSE','partecipation_request_response');



class PartecipationRequests extends Controller {
    private $ideaModel;
    private $userModel;
    private $abilityModel;
    private $partecipationrequestModel;
    private $teamModel;

    public function __construct(){
        $this->ideaModel = $this->model(IdeaModel::class);
        $this->userModel = $this->model(User::class);
        $this->abilityModel = $this->model(Ability::class);
        $this->partecipationrequestModel = $this->model(PartecipationRequestModel::class);
        $this->teamModel = $this->model(TeamModel::class);
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
        if($_SERVER[REQUEST_METHOD_KEY] == 'POST' && isset($_POST[TEAM_CHECKED_NAME]) && is_array($_POST[TEAM_CHECKED_NAME])) {
            foreach ($_POST[TEAM_CHECKED_NAME] as $teamId) {
                $member = new MemberDTO();
                $member->setPartecipationRequestId($participantRequestId);
                $member->setTeamId($teamId);
                $this->teamModel->newMember($member);
            }
            flash("add_participant_to_teams", "Utente assegnato ad i team con successo!");
            redirect('partecipationRequests/manageIdeaPartecipants/'.$ideaId);
        }
        $data[TEAM_LIST_KEY] = $this->teamModel->getByIdeaIdAndParticipantRequestId($ideaId, $participantRequestId);
        $user = $this->userModel->getUserById(($this->partecipationrequestModel->getPartecipationRequestById($participantRequestId))->getUserId());
        $data['USER_DATA'] = $user->getFirstName() . " " . $user->getLastName();

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
            if($this->partecipationrequestModel->isUserAlreadyInvited($userId,$ideaId)){
                redirect('');
            }else{
                //Effettuo l'inserimento
                $partReq = new PartecipationRequestDTO();
                $partReq->setUserId($userId);
                $partReq->setIdeaId($ideaId);
                $partReq->setIsPending(true);
                $partReq->setIsUserRequesting(false);

                if($this->partecipationrequestModel->createPartecipationRequest($partReq)){
                    flash('INVITE_CORRECTLY_SENT', 'Invito alla partecipazione correttamente inviato!');
                    redirect('partecipationRequests/manageIdeaPartecipants/'.$ideaId);
                }else{
                    die(SOMETHING_WENT_WRONG);
                }


            }
        }elseif ($typo=='true'){
            //Sono qui se la richiesta la sta facendo l'utente all'idea
            //Effettuo l'inserimento
            $partReq = new PartecipationRequestDTO();
            $partReq->setUserId($_SESSION[USER_ID]);
            $partReq->setIdeaId($ideaId);
            $partReq->setIsPending(true);
            $partReq->setIsUserRequesting(true);

            if ($this->partecipationrequestModel->createPartecipationRequest($partReq)){
                flash('REQUEST_CORRECTLY_SENT', 'Richiesta di partecipazione correttamente inviata!');
                redirect('ideas/showIdea/'.$ideaId);
            }else{
                die(SOMETHING_WENT_WRONG);
            }
        }else{
            redirect('');
        }
    }

    public function getPartecipationRequestList($requestType = null,$ideaId = null){
        if(!isLoggedIn() || $requestType == null){
            redirect('');
        }

        $outData = [];

        if($requestType == USERTYPE){
            //Caso in cui voglio visualizzare tutte le richeste di partecipazione di un utente
            $outData[REQUEST_CONTROL_TYPE] = USERTYPE;
            $outData[REQUESTS_DTO] = $this->partecipationrequestModel->getPartecipationRequestByUserId($_SESSION[USER_ID]);

            foreach ($outData[REQUESTS_DTO] as $request){
                $outData['ideasDTO'][$request->getPartecipationRequestId()] = $this->ideaModel->getIdeaById($request->getIdeaId());
                $outData['ideasOwner'][$request->getPartecipationRequestId()] = $this->userModel->getIdeaOwner($request->getIdeaId());
                $outData[USERDTO_KEY][$request->getPartecipationRequestId()] = $this->userModel->getUserById($request->getUserId());
                $outData['COMMON_ABILITIES'][$request->getPartecipationRequestId()] = $this->abilityModel->getCommonAbilities($request->getUserId(),$request->getIdeaId());
            }
            $this->view('partecipationRequests/partecipationRequestList',$outData);

        }elseif ($requestType == IDEATYPE){
            //Caso in cui voglio visualizzare tutte le richieste di partecipazione di un'idea
            if($ideaId == null || $this->ideaModel->getIdeaById($ideaId)->getOwnerId() != $_SESSION[USER_ID]){
                redirect('');
            }

            $outData[REQUEST_CONTROL_TYPE] = IDEATYPE;
            $outData[REQUESTS_DTO] = $this->partecipationrequestModel->getPartecipationRequestByIdeaId($ideaId);
            $outData['ideaDTO'] = $this->ideaModel->getIdeaById($ideaId);
            foreach ($outData[REQUESTS_DTO] as $request){
                $outData[USERDTO_KEY][$request->getPartecipationRequestId()] = $this->userModel->getUserById($request->getUserId());
                $outData['COMMON_ABILITIES'][$request->getPartecipationRequestId()] = $this->abilityModel->getCommonAbilities($request->getUserId(),$request->getIdeaId());
            }

            $this->view('partecipationRequests/partecipationRequestList',$outData);

        }else{
            redirect('');
        }
    }

    public function requestReply($requestId = null, $requestResponse = null){

        if(!isLoggedIn() || $requestResponse == null){
            redirect('');
        }

        $request = $this->partecipationrequestModel->getPartecipationRequestById($requestId);
        if(!$request){
            redirect('');
        }

        if(!$request->getIsPending()){
            redirect('');
        }

        if($request->getIsUserRequesting()){
            //Vuol dire che è il proprietario a dover accettare la richiesta e nessun altro

            //Controllo se l'utente loggato è il proprietario dell'idea
            if($_SESSION[USER_ID] != ($this->ideaModel->getIdeaById($request->getIdeaId()))->getOwnerId() ){
                redirect('');
            }

            if($requestResponse == REQUEST_RESPONSE_ACCEPT){
                if($this->partecipationrequestModel->editPartecipationRequest($requestId,false)){
                    flash(FLASH_KEY_PARTECIPATION_REQU_RESPONSE,'La richiesta di partecipazione è stata correttamente accettata!');
                    redirect('partecipationRequests/getPartecipationRequestList/idea/' . $request->getIdeaId());
                }else{
                    die(SOMETHING_WENT_WRONG);
                }
            }elseif ($requestResponse == REQUEST_RESPONSE_REJECT){
                if($this->partecipationrequestModel->deletePartecipationRequest($requestId)){
                    flash(FLASH_KEY_PARTECIPATION_REQU_RESPONSE,'La richiesta di partecipazione è stata correttamente rigettata!');
                    redirect('partecipationRequests/getPartecipationRequestList/idea/' . $request->getIdeaId());
                }else{
                    die(SOMETHING_WENT_WRONG);
                }
            }else{
                redirect('');
            }
        }else{
            //Vuol dire che è l'utente a dover accettare la richiesta di partecipazione a quella determinata idea

            //Controllo se l'utente loggato è l'utente nella richiesta di partecipazione
            if($_SESSION[USER_ID] != $request->getUserId() ){
                redirect('');
            }

            if($requestResponse == REQUEST_RESPONSE_ACCEPT){
                if($this->partecipationrequestModel->editPartecipationRequest($requestId,false)){
                    flash(FLASH_KEY_PARTECIPATION_REQU_RESPONSE,'La richiesta di partecipazione è stata correttamente accettata!');
                    redirect('ideas/getIdeasByPartecipant');
                }else{
                    die(SOMETHING_WENT_WRONG);
                }
            }elseif ($requestResponse == REQUEST_RESPONSE_REJECT){
                if($this->partecipationrequestModel->deletePartecipationRequest($requestId)){
                    flash(FLASH_KEY_PARTECIPATION_REQU_RESPONSE,'La richiesta di partecipazione è stata correttamente rigettata!');
                    redirect('partecipationRequests/getPartecipationRequestList/user');
                }else{
                    die(SOMETHING_WENT_WRONG);
                }
            }else{
                redirect('');
            }
        }
    }

    public function removePartecipation($ideaId = null, $requestType = null, $partecipationReqId = null){
        if(!isLoggedIn() || $ideaId==null || $requestType == null){
            redirect("");
        }
        if(!$this->ideaModel->getIdeaById($ideaId)){
            redirect("");
        }

        if($requestType == USERTYPE){
            if($this->partecipationrequestModel->deletePartecipationRequestByUserId($ideaId,$_SESSION[USER_ID])){
                flash("REMOVE_PARTECIPATION_SUCCESS","Sei uscito con successo dall'idea!");
                redirect('/ideas/getIdeasByPartecipant' );
            }else{
                die(SOMETHING_WENT_WRONG);
            }
        }elseif ($requestType == IDEATYPE){

            if($partecipationReqId==null){
                redirect('');
            }
            if($this->partecipationrequestModel->deletePartecipationRequest($partecipationReqId)){
                flash("REMOVE_PARTECIPATION_SUCCESS","Partecipante rimosso con successo!");
                redirect('/partecipationRequests/manageIdeaPartecipants/'.$ideaId );
            }else{
                die(SOMETHING_WENT_WRONG);
            }
        }
    }
}