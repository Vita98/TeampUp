<?php

define('REALIZATION_PHASE_DTO','realizationPhaseDTO');
define('REALIZATION_PHASE_DTO_ID','realizationPhaseDTO_id');

define('ABILITIES','abilities');
define('ERRORS', 'errors');
define('CHECKED', 'checked');
define('EDITMODE', 'editMode');

define('DESCRIPT_FIELD', 'description');
define('TITLE_FIELD', 'title');
define('IDEA_ID','ideaId');
define('IDEA_DTO','ideaDTO');
define('USER_ID','userId');

define('IDEA_MESSAGE','idea_message');

define('REALIZATION_PHASE_NEW_VIEW','realizationPhases/newRealizationPhase');
define('REALIZATION_PHASE_EDIT_VIEW','realizationPhases/editRealizationPhase');
define('REALIZATION_PHASES_MANAGE_VIEW', 'realizationPhases/manageRealizationPhases');
define('SHOW_IDEA_VIEW','ideas/showIdea/');


class RealizationPhases extends Controller
{
    private $ideaModel;
    private $realizationPhaseModel;
    private $abilityModel;

    public function __construct()
    {
       $this->realizationPhaseModel = $this->model(RealizationPhaseModel::class);
        $this->ideaModel = $this->model(IdeaModel::class);
        $this->abilityModel = $this->model(Ability::class);
    }


    public function newRealizationPhase($id = null){
        if (!isLoggedIn()) {
            redirect("");
        }

        $realizationPhaseDTO = new realizationPhaseDTO;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $id = $_POST[IDEA_ID];
            if ($this->ideaModel->getIdeaById($id)->getOwnerId() != $_SESSION[USER_ID]) {
                redirect("");
            }
            $data = null;
            $data[IDEA_ID] = $id;
            $data = $this->realizationPhaseDataFromPost($data  ,$realizationPhaseDTO);
            $data = $this->errorCheck($data);

            //check if errors are present
            if (empty($data[ERRORS][TITLE_FIELD]) && empty($data[ERRORS][CHECKED])) {
                //validated
                $data[REALIZATION_PHASE_DTO]->setIdeaId($id);
                $realizationPhase_id = $this->realizationPhaseModel->createRealizationPhase($data[REALIZATION_PHASE_DTO]);

                if ($realizationPhase_id) {
                    foreach ($_POST[ABILITIES] as $ability) {

                        $this->realizationPhaseModel->assAbilityRealizationPhase($realizationPhase_id, $ability);
                    }
                    flash(IDEA_MESSAGE, "La fase di realizzazione è stata aggiunta correttamente!");
                    redirect(SHOW_IDEA_VIEW . $id);
                } else {
                    die('Qualcosa è andato storto...');
                }
            } else {
                $data[ABILITIES] = $this->abilityModel->getAllAbilities();
                if (isset($_POST[ABILITIES])) {
                    foreach ($_POST[ABILITIES] as $checkedAbility) {
                        array_push($data[CHECKED], $checkedAbility);
                    }
                }
                $this->view(REALIZATION_PHASE_NEW_VIEW, $data);
            }
        } else{
            if (!$this->ideaModel->getIdeaById($id)  || $this->ideaModel->getIdeaById($id)->getOwnerId() != $_SESSION[USER_ID]) {
                redirect("");
            }
            $data = [
                ERRORS => [TITLE_FIELD => "", DESCRIPT_FIELD => "", CHECKED => ""],
                CHECKED => [],
                REALIZATION_PHASE_DTO => $realizationPhaseDTO,
                ABILITIES => $this->abilityModel->getAllAbilities(),
                IDEA_ID => $id
            ];
            $this->view(REALIZATION_PHASE_NEW_VIEW,$data);
        }
    }

    public function editRealizationPhase($id = null){

        if (!isLoggedIn()) {
            redirect("");
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $realizationPhaseDTO = $this->realizationPhaseModel->getRealizationPhaseById($_POST['id']);
            if ($this->ideaModel->getIdeaById($realizationPhaseDTO->getIdeaId())->getOwnerId() != $_SESSION[USER_ID]) {
                redirect("");
            }
            $data = null;
            $data = $this->realizationPhaseDataFromPost($data  ,$realizationPhaseDTO);
            $data = $this->errorCheck($data);

            //validate title
            if (empty($realizationPhaseDTO->getName())) {
                $data[ERRORS][TITLE_FIELD] = 'Inserisci un titolo valido';
            }
            if (!isset($_POST[ABILITIES])) {
                $data[ERRORS][CHECKED] = 'Seleziona almeno un abilità necessaria';
            }
            //check if errors are present
            if (empty($data[ERRORS][TITLE_FIELD]) && empty($data[ERRORS][CHECKED])) {
                //validated
               $this->realizationPhaseModel->updateRealizationPhase($data[REALIZATION_PHASE_DTO]->getId(), $data[REALIZATION_PHASE_DTO]->getName());
               $this->realizationPhaseModel->deleteAbilityByRealizationPhase($data[REALIZATION_PHASE_DTO]->getId());


                foreach ($_POST[ABILITIES] as $ability) {

                    $this->realizationPhaseModel->assAbilityRealizationPhase($data[REALIZATION_PHASE_DTO]->getId(), $ability);
                }
                flash(IDEA_MESSAGE, "La fase di realizzazione è stata modificata correttamente!");
                redirect(SHOW_IDEA_VIEW . $data[REALIZATION_PHASE_DTO]->getIdeaId());

            } else {
                $data[ABILITIES] = $this->abilityModel->getAllAbilities();
                if (isset($_POST[ABILITIES])) {
                    foreach ($_POST[ABILITIES] as $checkedAbility) {
                        array_push($data[CHECKED], $checkedAbility);
                    }
                }
                $this->view(REALIZATION_PHASE_EDIT_VIEW, $data);
            }
        } else{


                 $realizationPhaseDTO = $this->realizationPhaseModel->getRealizationPhaseById($id);
                if (!$this->ideaModel->getIdeaById($realizationPhaseDTO->getIdeaId()) || $this->ideaModel->getIdeaById($realizationPhaseDTO->getIdeaId())->getOwnerId() != $_SESSION[USER_ID]) {
                    redirect("");
                }
                $data = [
                    ERRORS => [TITLE_FIELD => "", DESCRIPT_FIELD => "", CHECKED => ""],
                    CHECKED => [],
                    REALIZATION_PHASE_DTO => $realizationPhaseDTO,
                    ABILITIES => $this->abilityModel->getAllAbilities()
                ];
                $toCheck = $this->realizationPhaseModel->getAbilityByRealizationPhase($realizationPhaseDTO->getId());
                 foreach($toCheck as $ability){
                    array_push($data[CHECKED], $ability->getId());
                }

                $this->view(REALIZATION_PHASE_EDIT_VIEW,$data);

        }
    }

    public function manageRealizationPhases($id = null){
        if (!isLoggedIn()) {
            redirect("");
        }
        if($id != null){
            if (!$this->ideaModel->getIdeaById($id) || $this->ideaModel->getIdeaById($id)->getOwnerId() != $_SESSION[USER_ID]) {
                redirect("");
            }
            $data[IDEA_DTO] = $this->ideaModel->getIdeaById($id);
            $data[REALIZATION_PHASE_DTO] = $this->realizationPhaseModel->getRealizationPhaseByIdea($id);
            $this->view(REALIZATION_PHASES_MANAGE_VIEW,$data);
        } else {

            if (!$this->ideaModel->getIdeaById($id) || $this->ideaModel->getIdeaById($data[IDEA_DTO]->getId())->getOwnerId() != $_SESSION[USER_ID]) {
                redirect("");
            }
            $data[REALIZATION_PHASE_DTO] = $this->realizationPhaseModel->getRealizationPhaseByIdea($id);
            $this->view(REALIZATION_PHASES_MANAGE_VIEW,$data);
        }

    }

    private function realizationPhaseDataFromPost($data ,$realizationPhaseDTO){
        $data[CHECKED] = [];
        $data[ERRORS] = [TITLE_FIELD => "", CHECKED => ""];
        $realizationPhaseDTO->setName(trim($_POST[TITLE_FIELD]));
        $data[REALIZATION_PHASE_DTO] = $realizationPhaseDTO;

        return $data;
    }

    private function errorCheck($data){
        //validate title
        if (empty($data[REALIZATION_PHASE_DTO]->getName())) {
            $data[ERRORS][TITLE_FIELD] = 'Inserisci un titolo valido';
        }
        if (!isset($_POST[ABILITIES])) {
            $data[ERRORS][CHECKED] = 'Seleziona almeno un abilità necessaria';
        }

        return $data;
    }



}