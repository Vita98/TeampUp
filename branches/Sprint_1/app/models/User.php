<?php


    class User {
        protected $database;

        public function __construct(){
            $this->database = new Database();
        }

        public function createUser(UserDTO $user): bool {
            $this->database->query("INSERT INTO user (firstName, lastName, email, psw) VALUES (:firstName, :lastName, :email, :password)");
            //Bind values
            $this->database->bind(':firstName', $user->getFirstName());
            $this->database->bind(':lastName', $user->getLastName());
            $this->database->bind(':email', $user->getEmail());
            $this->database->bind(':password', $user->getPsw());

            return $this->database->execute();
        }

        // Find user by email
        public function findUserByEmail($email): bool{
            $this->database->query('SELECT * FROM user WHERE email = :email');
            // Bind value
            $this->database->bind(':email', $email);

            $row = $this->database->single();

            // Check row
            if($this->database->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

        /**
         * Function used to check id the user exist into the database
         * @param UserDTO $user user instance with at leas the email and psw field compiled
         * @return bool|UserDTO
         */
        public function existUserByEmailAndPswHash(UserDTO $user){
            $this->database->query('SELECT * FROM user WHERE email = :email ');
            $this->database->bind(':email', $user->getEmail());

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

            //Removing the psw from the result
            $user->setPsw("");
            return $user;
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

            $this->database->bind(':lastName', $user->getLastName());
            $this->database->bind(':firstName', $user->getFirstName());
            $this->database->bind(':id', $user->getId());
            //if(!empty($user->getPsw())) $this->database->bind(':psw', $user->getPsw());

            return $this->database->execute();
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

