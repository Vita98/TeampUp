<?php
define('IDEADTO', 'ideaDTO');

define('ERRORS', 'errors');
define('CATEGORIES', 'categories');
define('CHECKED', 'checked');

define('DESCRIPT_FIELD', 'description');
define('TITLE_FIELD', 'title');


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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data[CHECKED] = [];
            $data[ERRORS] = [TITLE_FIELD => "", DESCRIPT_FIELD => "", CHECKED => ""];
            $ideaDTO->setTitle(trim($_POST[TITLE_FIELD]));
            $ideaDTO->setDescription(trim($_POST[DESCRIPT_FIELD]));
            $ideaDTO->setOwnerId($_SESSION['userId']);
            $data[IDEADTO] = $ideaDTO;
            //validate title
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

            //check if errors are present
            if(empty($data[ERRORS][DESCRIPT_FIELD]) && empty($data[ERRORS][TITLE_FIELD]) && empty($data[ERRORS][CHECKED])){
                //validated
                $ideaDTO->setOwnerId($_SESSION['userId']);
                $idea_id = $this->ideaModel->createIdea($ideaDTO);
                if($idea_id){
                    foreach($_POST[CATEGORIES] as $category){
                        $this->categoryModel->assCategoryIdea($idea_id, $category);
                    }
                    flash('idea_message', "L'idea è stata aggiunta correttamente, id: ".$idea_id);
                    redirect('pages/index');
                }else{
                    die('Qualcosa è andato storto...');
                }
            }else{
                //load view with errors
                $data[CATEGORIES] = $this->categoryModel->getAll();
                if(isset($_POST[CATEGORIES])){
                    foreach($_POST[CATEGORIES] as $categoryChecked){
                        array_push($data[CHECKED], $categoryChecked);
                    }
                }
                $this->view('ideas/newIdea', $data);
            }

        } else {
            $data = [
                ERRORS => [TITLE_FIELD => "", DESCRIPT_FIELD => "", CHECKED => ""],
                CHECKED => [],
                IDEADTO => $ideaDTO,
                CATEGORIES => $this->categoryModel->getAll()
            ];

            $this->view('ideas/newIdea', $data);
        }
    }

    public function getIdeasByOwnerId($id){

        if(!isLoggedIn()){
            redirect("");
        }
        $data = [];
        $dto =[IDEADTO, CATEGORIES];
        $ideas = $this->ideaModel->getIdeasByOwnerId($id);
        foreach ($ideas as $idea){
            $dto[IDEADTO] = null;
            $dto[CATEGORIES] = null;
            $dto[IDEADTO] = $idea;
            $dto[CATEGORIES] = $this->categoryModel->getCategoryByIdea($idea->getId());
            array_push($data,$dto);
        }

        $this->view('ideas/MyIdeas', $data);
    }
}
