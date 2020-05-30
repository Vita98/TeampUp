<?php


class Ability {
    protected $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function getAbilitiesByUserId($userId){
        $this->database->query('SELECT ability.id, ability.description FROM ability, userAbilities WHERE ability.id=userAbilities.abilityId AND userId = :userId ');
        $this->database->bind(':userId', $userId);

        return $this->database->classesFromResultSet(AbilityDTO::class);
    }

}

class AbilityDTO {
    private $id;
    private $description;

    public function __construct(){
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }
}

