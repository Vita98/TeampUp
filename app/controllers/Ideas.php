<?php
define('IDEADTO', 'ideaDTO');
define('USERDTO', 'UserDTO');
define('FEEDBACK_AVG','feedbackAvg');
define('FEEDBACK','feedback');
define('IDEASDTO','ideasDTO');
define('OWNERS','owners');
define('REALIZATION_PHASE', 'RealizationPhase');

define('ERRORS', 'errors');
define('CATEGORIES', 'categories');
define('CHECKED', 'checked');
define('EDITMODE', 'editMode');

define('DESCRIPT_FIELD', 'description');
define('TITLE_FIELD', 'title');
define('HIDDEN_IDEA_ID_FIELD', 'hidden_id');
define('USER_ID_KEY', 'userId');
define('IDEA_SPONSOR_DATE_FIELD', 'idea_sponsor_date');
define('IDEA_SPONSOR_CATEGORY_ID_FIELD', 'idea_sponsor_category_id');

define('IDEA_EDIT_NEW_VIEW', 'ideas/newIdea');
define('SHOW_IDEA_VIEW','ideas/showIdea');
define('SHOW_IDEA_PATH','ideas/showIdea/');

define('BEST_IDEA_TYPE','bestIdeaType');
define('BEST_IDEA_INNOVATIVITY','INNOVATIVITY');
define('BEST_IDEA_CREATIVITY','CREATIVITY');
define('BEST_IDEA','');

define('SEARCH_MODE', "searchMode");

class Ideas extends Controller {
    private $ideaModel;
    private $categoryModel;
    private $userModel;
    private $sponsorCategoryModel;
    private $realizationPhaseModel;
    private $feedbackModel;

    public function __construct(){
        $this->ideaModel = $this->model(IdeaModel::class);
        $this->categoryModel = $this->model("IdeaCategoryModel");
        $this->userModel = $this->model(User::class);
        $this->sponsorCategoryModel = $this->model(SponsorCategoryModel::class);
        $this->feedbackModel = $this->model(Feedback::class);
        $this->realizationPhaseModel = $this->model(RealizationPhaseModel::class);
    }

    public function newIdea(){
        if(!isLoggedIn()){
            redirect("");
        }

        $ideaDTO = new IdeaDTO;
        if($_SERVER[REQUEST_METHOD_KEY] == 'POST'){
            //Sanitize post array
            $data = $this->ideaDataFromPost([], $ideaDTO);
            //validate title
            $data = $this->errorCheck($ideaDTO, $data);
            //check if errors are present
            if(empty($data[ERRORS][DESCRIPT_FIELD]) && empty($data[ERRORS][TITLE_FIELD]) && empty($data[ERRORS][CHECKED])){
                //validated
                $ideaDTO->setOwnerId($_SESSION[USER_ID_KEY]);
                $idea_id = $this->ideaModel->createIdea($ideaDTO);
                if($idea_id){
                    $this->categoriesSave($_POST[CATEGORIES], $idea_id);
                    flash('idea_message', "L'idea è stata aggiunta correttamente!");
                    redirect(SHOW_IDEA_PATH.$idea_id);
                }else{
                    die('Qualcosa è andato storto...');
                }
            }else{
                //load view with errors
                $data = $this->loadIdeaViewData($data, $this->categoryModel->getAll(), isset($_POST[CATEGORIES]) ? $_POST[CATEGORIES] : null);
                $this->view(IDEA_EDIT_NEW_VIEW, $data);
            }
        } else {
            $data = $this->initIdeaViewData($ideaDTO, false);
            $this->view(IDEA_EDIT_NEW_VIEW, $data);
        }
    }

    public function showIdea($id){
        $idea = $this->getAllIdeaInformation($id);
        if (isLoggedIn()){
            $feedback = $this->feedbackModel->existFeedback($_SESSION[USER_ID_KEY],$id);
            $idea[FEEDBACK] = $feedback;
        }

        if(!empty($idea[IDEADTO])){
            $this->view(SHOW_IDEA_VIEW, $idea);
        }else{
            redirect('');
        }
    }

    public function getIdeasByOwnerId(){
        if(!isLoggedIn()){
            redirect("");
        }

        $data = [];
        $dto =[IDEADTO, CATEGORIES];
        $ideas = $this->ideaModel->getIdeasByOwnerId($_SESSION[USER_ID_KEY]);
        foreach ($ideas as $idea){
            $dto[IDEADTO] = null;
            $dto[CATEGORIES] = null;
            $dto[IDEADTO] = $idea;
            $dto[CATEGORIES] = $this->categoryModel->getCategoryByIdea($idea->getId());
            array_push($data,$dto);
        }

        $this->view('ideas/myIdeas', $data);
    }

    public function editIdea($id){
        if(!isLoggedIn()){
            redirect("");
        }
        $ideaDTO = $this->ideaModel->getIdeaByID($id);
        if($ideaDTO->getOwnerId() != $_SESSION[USER_ID_KEY]){
            redirect("");
        }
        if($_SERVER[REQUEST_METHOD_KEY] == 'POST'){
            //Sanitize post array
            $data = $this->ideaDataFromPost([], $ideaDTO);
            //validate title
            $data = $this->errorCheck($ideaDTO, $data);
            //check if errors are present
            if(empty($data[ERRORS][DESCRIPT_FIELD]) && empty($data[ERRORS][TITLE_FIELD]) && empty($data[ERRORS][CHECKED])){
                //validated
                $this->ideaModel->updateIdea($ideaDTO);
                $this->categoryModel->deleteByIdeaId($ideaDTO->getId());
                $this->categoriesSave($_POST[CATEGORIES], $ideaDTO->getId());
                flash('idea_message', "L'idea è stata aggiornata correttamente!");
                redirect(SHOW_IDEA_PATH.$ideaDTO->getId());
            }else{
                //load view with errors
                $data = $this->loadIdeaViewData($data, $this->categoryModel->getAll(), isset($_POST[CATEGORIES]) ? $_POST[CATEGORIES] : null);
                $data[EDITMODE] = true;
                $this->view(IDEA_EDIT_NEW_VIEW, $data);
            }
        } else {
            $data = $this->initIdeaViewData($ideaDTO, true);
            $this->view(IDEA_EDIT_NEW_VIEW, $data);
        }
    }

    private function errorCheck($ideaDTO, $data){
        if(empty($ideaDTO->getTitle())){
            $data[ERRORS][TITLE_FIELD] = 'Inserisci un titolo valido';
        }
        if(!isset($_POST[CATEGORIES])){
            $data[ERRORS][CHECKED] = 'Seleziona almeno una categoria';
        }
        //validate description
        if(empty($ideaDTO->getDescription())){
            $data[ERRORS][DESCRIPT_FIELD] = 'Inserisci una descrizione valida';
        }
        return $data;
    }

    private function initIdeaViewData($ideaDTO, $editMode){
        $data = [
            ERRORS => [TITLE_FIELD => "", DESCRIPT_FIELD => "", CHECKED => ""],
            CHECKED => [],
            IDEADTO => $ideaDTO,
            CATEGORIES => $this->categoryModel->getAll(),
            EDITMODE => $editMode
        ];
        if($editMode){
            $toCheck = $this->categoryModel->getCategoryByIdea($ideaDTO->getId());
            foreach($toCheck as $category){
                array_push($data[CHECKED], $category->getId());
            }
        }
        return $data;
    }

    private function loadIdeaViewData($data, $allCategories, $checkedCategories){
        $data[CATEGORIES] = $allCategories;
        if(isset($checkedCategories)){
            foreach($checkedCategories as $checkedCategory){
                array_push($data[CHECKED], $checkedCategory);
            }
        }
        return $data;
    }

    private function categoriesSave($categories, $ideaId){
        foreach($categories as $category){
            $this->categoryModel->assCategoryIdea($ideaId, $category);
        }
    }

    private function ideaDataFromPost($data, $ideaDTO){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data[CHECKED] = [];
        $data[ERRORS] = [TITLE_FIELD => "", DESCRIPT_FIELD => "", CHECKED => ""];
        $ideaDTO->setTitle(trim($_POST[TITLE_FIELD]));
        $ideaDTO->setDescription(trim($_POST[DESCRIPT_FIELD]));
        $data[IDEADTO] = $ideaDTO;
        return $data;
    }

    public function sponsorIdea($id){
        $data = $this->initSponsorCategoryViewData($id);

        if($_SERVER[REQUEST_METHOD_KEY] == 'POST'){
            $data = $this->ideaDataSponsorFromPost($data, $data[IDEADTO]);
            $data = $this->ideaDataSponsorErrorCheck($data[IDEADTO], $data);

            if(empty($data[ERRORS][IDEA_SPONSOR_DATE_FIELD]) && empty($data[ERRORS][IDEA_SPONSOR_CATEGORY_ID_FIELD])) {
                $this->ideaModel->updateIdea($data[IDEADTO]);
                flash('idea_message', "L'idea è stata sponsorizzata correttamente!");
                redirect('ideas/showIdea/'.$data[IDEADTO]->getId());
            }
        }

        $this->view('ideas/sponsorIdea',$data);
    }

    public function initSponsorCategoryViewData($ideaId) {
        return [
            CATEGORIES => $this->sponsorCategoryModel->getAll(),
            IDEADTO => $this->ideaModel->getIdeaByID($ideaId),
            ERRORS => [
                IDEA_SPONSOR_DATE_FIELD => "",
                IDEA_SPONSOR_CATEGORY_ID_FIELD => ""
            ]
        ];

    }

    private function ideaDataSponsorFromPost($data, $ideaDTO) {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $ideaDTO->setSponsorStartDate(trim($_POST[IDEA_SPONSOR_DATE_FIELD]));
        if(isset($_POST[IDEA_SPONSOR_CATEGORY_ID_FIELD]) && is_array($_POST[IDEA_SPONSOR_CATEGORY_ID_FIELD]) && count($_POST[IDEA_SPONSOR_CATEGORY_ID_FIELD]) > 0) {
            $ideaDTO->setSponsorCategoryId(trim($_POST[IDEA_SPONSOR_CATEGORY_ID_FIELD][0]));
        }
        $data[IDEADTO] = $ideaDTO;
        return $data;
    }

    private function ideaDataSponsorErrorCheck($ideaDTO, $data) {
        if(empty($ideaDTO->getSponsorStartDate())) {
            $data[ERRORS][IDEA_SPONSOR_DATE_FIELD] = "Inserisci una data";
        }else if(!$this->validateDate($ideaDTO->getSponsorStartDate())) {
            $data[ERRORS][IDEA_SPONSOR_DATE_FIELD] = "La data inserita è errata";
        }

        if(empty($ideaDTO->getSponsorCategoryId())) {
            $data[ERRORS][IDEA_SPONSOR_CATEGORY_ID_FIELD] = "Devi selezionare una categoria";
        }

        return $data;
    }

    private function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function deleteIdea($id) {
        $data = $this->initDeleteIdeaViewData($id);

        if($_SERVER[REQUEST_METHOD_KEY] == 'POST'){
            $this->ideaModel->deleteIdea($data[IDEADTO]);
            redirect('ideas/getIdeasByOwnerId');
        }

        $this->view("ideas/deleteIdea", $data);
    }

    private function initDeleteIdeaViewData($id) {
        return [
            IDEADTO => $this->ideaModel->getIdeaByID($id)
        ];
    }

    public function newFeedback($ideaId){
        if(!isLoggedIn()){
            redirect('');
        }

        $idea = $this->getAllIdeaInformation($ideaId);
        if($idea[IDEADTO]){

            //Check if the requester have already submited the feedback
            $feedback = $this->feedbackModel->existFeedback($_SESSION[USER_ID_KEY],$ideaId);

            if ($feedback){
                $idea[FEEDBACK] = $feedback;
                $this->view(SHOW_IDEA_VIEW, $idea);
            }else{
                if (empty($_POST['ratingInnovativity']) || empty($_POST['ratingCreativity'])){
                    $idea['FEEDBACK_ERROR'] = true;
                    $this->view(SHOW_IDEA_VIEW, $idea);
                }else{
                    //Informazioni del feedback inserite correttamente
                    $innovativityVote = floatval($_POST['ratingInnovativity']) / 2;
                    $creativityVote = floatval($_POST['ratingCreativity']) / 2;
                    if ($this->feedbackModel->createFeedback($_SESSION[USER_ID_KEY],$ideaId,$creativityVote,$innovativityVote)){
                        flash('feedback_message', 'Feedback registrato con successo!');
                        redirect(SHOW_IDEA_PATH.$ideaId);
                    }else{
                        die("Qualcosa è andato storto!");
                    }
                }
            }

        }else{
            $this->view('pages/index', null);
        }

    }

    private function getAllIdeaInformation($id){
        $idea=[IDEADTO,CATEGORIES,USERDTO,FEEDBACK_AVG];
        $idea[IDEADTO] = $this->ideaModel->getIdeaByID($id);

        if($idea[IDEADTO]) {
            $idea[USERDTO] = $this->userModel->getUserById($idea[IDEADTO]->getOwnerId());
            $idea[CATEGORIES] = $this->categoryModel->getCategoryByIdea($idea[IDEADTO]->getId());
            $idea[FEEDBACK_AVG] = $this->feedbackModel->getAvgVoteByIdeaId($idea[IDEADTO]->getId(),BEST);
            $idea[REALIZATION_PHASE] = $this->realizationPhaseModel->getRealizationPhaseByIdea($id);
            return $idea;
        }else{
            return null;
        }
    }

    public function bestIdeas($bestIdeaType = ''){

        $ideas = null;
        $bestIdeaTypeQuery = null;

        switch ($bestIdeaType){
            case BEST_IDEA_INNOVATIVITY:
                $ideas = $this->ideaModel->getTopTen(INNOVATIVITY);
                $bestIdeaTypeQuery = INNOVATIVITY;
                break;
            case BEST_IDEA_CREATIVITY:
                $ideas = $this->ideaModel->getTopTen(CREATIVITY);
                $bestIdeaTypeQuery = CREATIVITY;
                break;
            case BEST_IDEA:
                $ideas = $this->ideaModel->getTopTen(BEST);
                $bestIdeaTypeQuery = BEST;
                break;
            default:
                $ideas = null;
        }

        if($ideas){

            $categories = [];
            $owners = [];
            $avgVotes = [];
            foreach ($ideas as $idea){
                $singleOwner = $this->userModel->getIdeaOwner($idea->id);

                $owners[$idea->id] = $singleOwner->getFirstName() . " " . $singleOwner->getLastName();
                $categories[$idea->id] = $this->categoryModel->getCategoryByIdea($idea->id);
                $avgVotes[$idea->id] = $this->feedbackModel->getAvgVoteByIdeaId($idea->id,$bestIdeaTypeQuery);
            }
            $data = [BEST_IDEA_TYPE=>$bestIdeaType,IDEASDTO=>$ideas,CATEGORIES=>$categories,OWNERS=>$owners,FEEDBACK_AVG=>$avgVotes];

            $this->view('ideas/bestIdeas',$data);
        }else{
            /*Se inserisco come parametro un valore non valido
              lo reindirizzo alla pagina con le idee migliori*/
            redirect('ideas/bestIdeas/');
        }
    }

    private function initSearchData(){
        return [
            CATEGORIES => $this->categoryModel->getAll(),
            CHECKED => [],
            INNOVATIVITY => null,
            CREATIVITY => null,
            FEEDBACK_AVG => null,
            TITLE_FIELD => null,
            SEARCH_MODE => false
        ];
    }

    private function searchDataFromGet($data){
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $data[IDEASDTO] = [];
        $data[CREATIVITY] = isset($_GET[CREATIVITY]) && $_GET[CREATIVITY] != null && strlen(trim($_GET[CREATIVITY])) ? trim($_GET[CREATIVITY])/2 : null;
        $data[INNOVATIVITY] = isset($_GET[INNOVATIVITY]) && $_GET[INNOVATIVITY] != null && strlen(trim($_GET[INNOVATIVITY])) ? trim($_GET[INNOVATIVITY])/2 : null;
        $data[FEEDBACK_AVG] = isset($_GET[FEEDBACK_AVG]) && $_GET[FEEDBACK_AVG] != null && strlen(trim($_GET[FEEDBACK_AVG])) ? trim($_GET[FEEDBACK_AVG])/2 : null;
        $data[TITLE_FIELD] = isset($_GET[TITLE_FIELD]) && $_GET[TITLE_FIELD] && strlen(trim($_GET[TITLE_FIELD])) != null ? trim($_GET[TITLE_FIELD]) : null;
        $data[CHECKED] = isset($_GET[CHECKED]) && count($_GET[CHECKED]) ? $_GET[CHECKED] : null;
        unset($_GET);
        return $data;
    }
    public function searchIdea(){
        if(!isLoggedIn()){
            redirect("");
        }

        $data = $this->initSearchData();

        if(isset($_GET[SEARCH_MODE]) && $_GET[SEARCH_MODE]){
            $data = $this->searchDataFromGet($data);
            $data[IDEASDTO] = $this->ideaModel->filteredSearch(
                $data[TITLE_FIELD], $data[CHECKED], $data[FEEDBACK_AVG], $data[INNOVATIVITY], $data[CREATIVITY]
            );
        }
        $this->view("ideas/search", $data);

    }
}
