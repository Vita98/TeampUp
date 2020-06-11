<?php

define('EMAIL_BIND_TOKEN',':email');
define('SEARCH', "SELECT DISTINCT user.id, user.firstName, user.lastName FROM (user " .
                " LEFT JOIN userAbilities ON user.id = userAbilities.userId ) " .
                " WHERE ( :firstName IS NULL OR user.firstName LIKE :firstName ) " .
                " AND ( :lastName IS NULL OR user.lastName LIKE :lastName ) " .
                " AND ( :ab1 IS NULL OR userAbilities.abilityId IN ");

define('FIND_USER_IDEA_PARTICIPANTS', "SELECT user.id, user.firstName, user.lastName ".
                                       "FROM idea ".
                                        "JOIN partecipationRequest ON idea.id=partecipationRequest.ideaId ".
                                        "JOIN user ON partecipationRequest.userId=user.id ".
                                        "WHERE idea.id=:ideaId and partecipationRequest.isPending = 0");

if (!defined('FIRST_NAME_KEY')) {define('FIRST_NAME_KEY','firstName');}
if (!defined('LAST_NAME_KEY')) {define('LAST_NAME_KEY','lastName');}

    class User {
        protected $database;

        public function __construct(){
            $this->database = new Database();
        }

        public function createUser(UserDTO $user): bool {
            $this->database->query("INSERT INTO user (firstName, lastName, email, psw) VALUES (:firstName, :lastName, :email, :password)");
            //Bind values
            $this->database->bind(FIRST_NAME_KEY, $user->getFirstName());
            $this->database->bind(LAST_NAME_KEY, $user->getLastName());
            $this->database->bind(EMAIL_BIND_TOKEN, $user->getEmail());
            $this->database->bind(':password', $user->getPsw());

            return $this->database->execute();
        }

        // Find user by email
        public function findUserByEmail($email): bool{
            $this->database->query('SELECT * FROM user WHERE email = :email');
            // Bind value
            $this->database->bind(EMAIL_BIND_TOKEN, $email);

            $this->database->single();

            // Check row
            return ($this->database->rowCount() > 0);
        }

        /**
         * Function used to check id the user exist into the database
         * @param UserDTO $user user instance with at leas the email and psw field compiled
         * @return bool|UserDTO
         */
        public function existUserByEmailAndPswHash(UserDTO $user){
            $this->database->query('SELECT * FROM user WHERE email = :email ');
            $this->database->bind(EMAIL_BIND_TOKEN, $user->getEmail());

            $existUser = $this->database->classFromSingle(UserDTO::class);

            if(password_verify($user->getPsw(), $existUser->getPsw())){
                return $existUser;
            }else{
                return false;
            }
        }

        /**
         * @param $id
         * @return mixed
         */
        public function getUserById($id){
            $this->database->query('SELECT * FROM user WHERE id = :id ');
            $this->database->bind(':id', $id);

            $user = $this->database->classFromSingle(UserDTO::class);
            if($user){
                //Removing the psw from the result
                $user->setPsw("");
                return $user;
            }else{
                return false;
            }

        }

        /**
         *
         */
        public function editUser(UserDTO $user){
            if (!empty($user->getPsw())){
                $this->database->query('UPDATE user SET firstName=:firstName, lastName=:lastName, psw=:psw WHERE id = :id ');
                $this->database->bind(':psw', $user->getPsw());
            }else{
                $this->database->query('UPDATE user SET firstName=:firstName, lastName=:lastName WHERE id = :id ');
            }

            $this->database->bind(LAST_NAME_KEY, $user->getLastName());
            $this->database->bind(FIRST_NAME_KEY, $user->getFirstName());
            $this->database->bind(':id', $user->getId());

            return $this->database->execute();
        }

        public function getUsersByNameSurnameSkills($firstName, $lastName, $abilities){
            $abilitiesPlaceHolder = ":ab1";

            if($abilities != null){
                for($i = 2; $i <= count($abilities); $i++){
                    $abilitiesPlaceHolder = $abilitiesPlaceHolder.", :ab".$i;
                }
            }

            $searchQuery = SEARCH . "(" . $abilitiesPlaceHolder . ") )";

            $this->database->query($searchQuery);
            $this->database->bind(FIRST_NAME_KEY, $firstName);
            $this->database->bind(LAST_NAME_KEY, $lastName);

            if($abilities != null){
                for($i = 1; $i <= count($abilities); $i++){
                    $this->database->bind(":ab".$i, $abilities[$i-1]);
                }
            } else {
                $this->database->bind(":ab1", null);
            }

            return $this->database->classesFromResultSet(UserDTO::class);

        }

        public function getIdeaOwner($ideaId){
            $this->database->query("SELECT user.* FROM idea JOIN user ON idea.ownerId=user.id WHERE idea.id = :ideaId");
            $this->database->bind(':ideaId', $ideaId);

            return $this->database->classFromSingle(UserDTO::class);
        }

        public function getUserIdeaParticipants($ideaId) {
            $this->database->query(FIND_USER_IDEA_PARTICIPANTS);
            $this->database->bind(":ideaId", $ideaId);

            return $this->database->classesFromResultSet(UserDTO::class);
        }
    }

    class UserDTO {
        private $id;
        private $firstName;
        private $lastName;
        private $email;
        private $psw;

        public function __construct(){
        }

        public function compileAll($id,$firstName,$lastName,$email,$psw){
            $this->id = $id;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $this->psw = $psw;
        }

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getFirstName(){
            return $this->firstName;
        }

        public function setFirstName($firstName){
            $this->firstName = $firstName;
        }

        public function getLastName(){
            return $this->lastName;
        }

        public function setLastName($lastName){
            $this->lastName = $lastName;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function getPsw(){
            return $this->psw;
        }

        public function setPsw($psw){
            $this->psw = $psw;
        }

    }

