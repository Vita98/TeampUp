<?php

define('INNOVATIVITY','avgInnovativity');
define('CREATIVITY','avgCreativity');
define('BEST','avgVote');

class Feedback {
    protected $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function getAvgVoteByIdeaId($ideaId,$voteType){

        $select_op = "";
        switch ($voteType){
            case INNOVATIVITY:
                $select_op = "AVG(feedback.innovativityVote) as avgInnovativity";
                break;
            case CREATIVITY:
                $select_op = "AVG(feedback.creativityVote) as avgCreativity";
                break;
            case BEST:
                $select_op = "AVG( (feedback.creativityVote + feedback.innovativityVote) / 2 ) as avgVote";
                break;
            default:
                return null;
        }

        $this->database->query("SELECT " . $select_op . " FROM feedback WHERE idea_id = :ideaId GROUP BY idea_id");
        $this->database->bind(':ideaId',$ideaId);

        $res = $this->database->single();

        if($this->database->rowCount() == 0){
            return 0;
        }else{
            return floatval($res->$voteType);
        }
    }

    public function createFeedback($userId, $ideaId, $creativityVote, $innovativityVote){
        $this->database->query("INSERT INTO feedback VALUES (:userId, :ideaId, :innovativityVote, :creativityVote) ");
        $this->database->bind(':userId',$userId);
        $this->database->bind(':ideaId',$ideaId);
        $this->database->bind(':innovativityVote',$innovativityVote);
        $this->database->bind(':creativityVote',$creativityVote);

        return $this->database->execute();
    }

    public function existFeedback($userId,$ideaId){
        $this->database->query("SELECT * FROM feedback WHERE users_id = :userId AND idea_id = :ideaId");
        $this->database->bind(':userId',$userId);
        $this->database->bind(':ideaId',$ideaId);

        return $this->database->single();;
    }

}

class FeedbackDTO {
    private $id;
    private $innovativityVote;
    private $creativityVote;
    private $ideaId;
    private $userId;

    public function __construct(){
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getInnovativityVote(){
        return $this->innovativityVote;
    }

    public function setInnovativityVote($innovativityVote){
        $this->$innovativityVote = $innovativityVote;
    }

    public function getCreativityVote(){
        return $this->creativityVote;
    }

    public function setCreativityVote($creativityVote){
        $this->creativityVote = creativityVote;
    }

    public function getIdeaId(){
        return $this->ideaId;
    }

    public function setIdeaId($ideaId){
        $this->ideaId = $ideaId;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function setUserId($userId){
        $this->userId = $userId;
    }
}

