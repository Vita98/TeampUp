<?php
define('IDEADTO', 'ideaDTO');

define('ERRORS', 'errors');
define('CATEGORIES', 'categories');
define('CHECKED', 'checked');
define('EDITMODE', 'editMode');

define('DESCRIPT_FIELD', 'description');
define('TITLE_FIELD', 'title');
define('HIDDEN_IDEA_ID_FIELD', 'hidden_id');
define('USER_ID_KEY', 'userId');

define('IDEA_EDIT_NEW_VIEW', 'ideas/newIdea');

class Ideas extends Controller {
    private $ideaModel;
    private $categoryModel;

    public function __construct(){
        $this->ideaModel = $this->model(IdeaModel::class);
        $this->categoryModel = $this->model(IdeaCategoryModel::class);
    }

    public function newIdea(){
        if(!isLoggedIn()){
            redirect("");
        }

        $ideaDTO = new IdeaDTO;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
                    redirect('ideas/showIdea/'.$idea_id);
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
        $idea=[IDEADTO,CATEGORIES];
        $idea[IDEADTO] = $this->ideaModel->getIdeaByID($id);
        if($idea[IDEADTO]) {
            $idea[CATEGORIES] = $this->categoryModel->getCategoryByIdea($idea[IDEADTO]->getId());

            $this->view('ideas/showIdea', $idea);
        }
        else{
            $this->view('pages/index', null);
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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
                redirect('ideas/showIdea/'.$ideaDTO->getId());
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
}
