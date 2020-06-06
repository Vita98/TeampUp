<?php

define('CREATE_REALIZATION_PHASE_QUERY', 'INSERT INTO realizationPhase(name, ideaId) VALUES (:name, :ideaId)');
define('INSERT_ABILITY_REALIZATION_PHASE',"INSERT INTO realizationPhaseAbilities(realizationphase_id,ability_id) VALUES (:realizationPhaseId, :abilityId)");
define('GET_ABILITIES_BY_REALIZATION_PHASE', "SELECT ability.* FROM realizationPhaseAbilities JOIN ability WHERE realizationPhaseAbilities.ability_id = ability.id AND realizationPhase_id = :realizationPhaseId  ");
define('GET_REALIZATION_PHASE_BY_IDEA', "SELECT * FROM realizationPhase WHERE ideaId = :ideaId");
define('UPDATE_REALIZATION_PHASE',"UPDATE realizationPhase SET name = :name where id = :id");
define('GET_REALIZATION_PHASE_BY_ID', "SELECT * FROM realizationPhase WHERE id = :id");
define('DELETE_ABILITY_BY_REALIZATION_PHASE', "DELETE FROM realizationPhaseAbilities WHERE realizationphase_id = :realizationphase_id");


class RealizationPhaseModel
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function createRealizationPhase(RealizationPhaseDTO $realizationPhaseDTO){
        $this->database->query(CREATE_REALIZATION_PHASE_QUERY);
        $this->database->bind(':name', $realizationPhaseDTO->getName());
        $this->database->bind(':ideaId',$realizationPhaseDTO->getIdeaId());

        if($this->database->execute()){
            return $this->database->lastInsertId();
        }
        return false;
    }

    public function getRealizationPhaseById($id){
        $this->database->query(GET_REALIZATION_PHASE_BY_ID);
        $this->database->bind(':id',$id);

        return $this->database->classFromSingle(RealizationPhaseDTO::class);
    }

    public function assAbilityRealizationPhase($realizationPhaseId, $abilityId){
        $this->database->query(INSERT_ABILITY_REALIZATION_PHASE);
        $this->database->bind(":realizationPhaseId", $realizationPhaseId);
        $this->database->bind(":abilityId", $abilityId);

        return $this->database->execute();
    }

    public function getAbilityByRealizationPhase($realizationPhaseId){
        $this->database->query(GET_ABILITIES_BY_REALIZATION_PHASE);
        $this->database->bind(":realizationPhaseId", $realizationPhaseId);

        return $this->database->classesFromResultSet(AbilityDTO::class);
    }

    public function getRealizationPhaseByIdea($ideaId){
        $this->database->query(GET_REALIZATION_PHASE_BY_IDEA);
        $this->database->bind(":ideaId", $ideaId);

        return $this->database->classesFromResultSet(RealizationPhaseDTO::class);
    }

    public function updateRealizationPhase($id , $name){
        $this->database->query(UPDATE_REALIZATION_PHASE);
        $this->database->bind(':id', $id);
        $this->database->bind(':name', $name);

        return $this->database->execute();
    }

    public function deleteAbilityByRealizationPhase($id){
        $this->database->query(DELETE_ABILITY_BY_REALIZATION_PHASE);
        $this->database->bind(':realizationphase_id',$id);

        return $this->database->execute();
    }


}

class RealizationPhaseDTO
{
    private $id;
    private $name;
    private $ideaId;

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



}