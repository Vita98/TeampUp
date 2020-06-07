<?php

define('USERDTO_KEY','userDTO');
define('USER_ABILITIES_KEY','userAbilities');
define('FIRST_NAME_KEY','firstName');
define('LAST_NAME_KEY','lastName');
define('CHECKED', 'checked');

class PartecipationRequests extends Controller {
    private $ideaModel;
    private $userModel;
    private $abilityModel;
    private $partecipationrequestModel;

    public function __construct(){
        $this->ideaModel = $this->model(IdeaModel::class);
        $this->userModel = $this->model(User::class);
        $this->abilityModel = $this->model(Ability::class);
        $this->partecipationrequestModel = $this->model(PartecipationRequestModel::class);
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
        if($_SESSION['userId'] != $idea->getOwnerId()){
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

        $data['ideaId'] = $ideaId;
        $this->view('partecipationRequests/manageIdeaPartecipants', $data);
    }

    public function newPartecipationRequestChooser($ideaId = null){
        if(!$this->checkIdeaProprety($ideaId)){
            redirect('');
        }

        $data = [ USERDTO_KEY =>[], USER_ABILITIES_KEY => [], CHECKED => [], FIRST_NAME_KEY=> "", LAST_NAME_KEY=>"", 'ideaId' => $ideaId ,'post'=>false];
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
            if($this->partecipationrequestModel->isUserAlreadyInvited($user->getId(),$ideaId) || $_SESSION['userId']==$user->getId()){
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

            if($_SESSION['userId'] != $idea->getOwnerId()){
                redirect('');
            }

            //Controllo se l'utente ha gia inviato un invito a quell'utente
            if($this->partecipationrequestModel->isUserAlreadyInvited($userId,$ideaId) || $_SESSION['userId']==$userId){
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
            $partReq = new PartecipationRequestDTO($_SESSION['userId'],$ideaId,true,true);
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