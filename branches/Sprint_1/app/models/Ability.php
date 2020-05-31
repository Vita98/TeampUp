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

    public function getAllAbilities(){
        $this->database->query('SELECT * FROM ability');
        return $this->database->classesFromResultSet(AbilityDTO::class);
    }

    public function dropAllAlibitiesByUserId($userId){
        $this->database->query('DELETE FROM userAbilities WHERE userId = :userId');
        $this->database->bind(':userId', $userId);

        return $this->database->execute();
    }

    public function addAbilityToUser($abilityId,$userId){
        $this->database->query('INSERT INTO userAbilities (userId,abilityId) VALUES (:userId, :abilityId)');
        $this->database->bind(':userId', $userId);
        $this->database->bind(':abilityId', $abilityId);

        return $this->database->execute();
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

