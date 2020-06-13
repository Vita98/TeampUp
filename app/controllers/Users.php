<?php

define('INDEX_PAGE','pages/index');
define('LOGIN_PAGE','users/login');

define('FIRST_NAME_KEY','firstName');
define('LAST_NAME_KEY','lastName');
define('EMAIL_KEY','email');
define('CONFIRM_PSW_KEY','confirm_psw');
define('ERRORS_KEY','errors');

define('USERDTO_KEY','userDTO');
define('USERID_KEY', "userId");
define('USER_ABILITIES_KEY','userAbilities');
define('OLD_PSW_KEY','old_psw');
define('NEW_PSW_KEY','new_psw');
define('CHECKED', 'checked');
//La chiave request method serve ovunque, l'ho pushata in CONFIG.PHP

define('ENTER_NAME_ERROR','Inserisci un nome!');
define('ENTER_SURNAME_ERROR', 'Inserisci un cognome!');
define('PSW_LENGTH_ERROR','La password deve essere almeno di 6 caratteri');
define('PSW_NOT_THE_SAME_ERROR','La password non corrisponde!');


    class Users extends Controller{
        private $userModel;
        private $abilityModel;
        private $partecipationRequestModel;
        public function __construct() {
            $this->userModel = $this->model('User');
            $this->abilityModel = $this->model('Ability');
            $this->partecipationRequestModel = $this->model(PartecipationRequestModel::class);
            $this->ideaModel = $this->model(IdeaModel::class);
        }

        /**
         * Function for the signUp
         */
        public function signUp(){
            //Check if the user is logged in
            if(isLoggedIn()){
                redirect(INDEX_PAGE);
            }

            //preparing the error vector
            $errors = [
                FIRST_NAME_KEY => '',
                LAST_NAME_KEY => '',
                EMAIL_KEY => '',
                'psw' => '',
                CONFIRM_PSW_KEY => ''
            ];

            $newUser = new UserDTO;

            //Cheching the post request
            if($_SERVER[REQUEST_METHOD_KEY] == 'POST'){
                //Sanitize the POST data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

                $foundError = false;

                //Validating the email
                if(isset($_POST[EMAIL_KEY]) && !empty($_POST[EMAIL_KEY])){
                    // Check email
                    if($this->userModel->findUserByEmail($_POST[EMAIL_KEY])){
                        $errors[EMAIL_KEY] = 'Email già usata!';
                        $foundError = true;
                    }
                    $newUser->setEmail($_POST[EMAIL_KEY]);
                } else{
                    $errors[EMAIL_KEY] = 'Inserisci una email!';
                    $foundError = true;
                }

                // Validate lastName
                if(isset($_POST[LAST_NAME_KEY]) && !empty($_POST[LAST_NAME_KEY])){
                    $newUser->setLastName($_POST[LAST_NAME_KEY]);
                } else {
                    $errors[LAST_NAME_KEY] = ENTER_NAME_ERROR;
                    $foundError = true;
                }

                // Validate firstName
                if(isset($_POST[FIRST_NAME_KEY]) && !empty($_POST[FIRST_NAME_KEY])){
                    $newUser->setFirstName($_POST[FIRST_NAME_KEY]);
                } else {
                    $errors[FIRST_NAME_KEY] = ENTER_NAME_ERROR;
                    $foundError = true;
                }

                // Validate Password
                if(isset($_POST['psw']) && !empty($_POST['psw'])){
                    if(strlen($_POST['psw']) < 6){
                        $errors['psw'] = PSW_LENGTH_ERROR;
                        $foundError = true;
                    } else {
                        $newUser->setPsw($_POST['psw']);
                    }
                } else {
                    $errors['psw'] = 'Inserisci una password!';
                    $foundError = true;
                }

                // Validate Confirm Password
                if(isset($_POST['psw']) && !empty($_POST['psw'])){
                    if($_POST['psw'] != $_POST[CONFIRM_PSW_KEY]) {
                        $errors[CONFIRM_PSW_KEY] = PSW_NOT_THE_SAME_ERROR;
                        $foundError = true;
                    }
                } else {
                    $errors[CONFIRM_PSW_KEY] = 'Conferma la password!';
                    $foundError = true;
                }

                //Creating the user only if no errors found
                if(!$foundError){

                    //Hashing the psw
                    $newUser->setPsw(password_hash($newUser->getPsw(),PASSWORD_BCRYPT));

                    //Inserting the user into the database
                    if($this->userModel->createUser($newUser)){
                        flash('register_success', 'Sei registrato e ora ti puoi loggare!');
                        redirect(LOGIN_PAGE);
                    } else {
                        die("Qualcosa è andato storto!");
                    }
                }else{
                    //I'm here becouse i've found some errors
                    //Loading the view with the errors
                    $this->view('users/signUp',[ERRORS_KEY => $errors, USERDTO_KEY => $newUser]);
                }
            } else {
                $this->view('users/signUp',[ERRORS_KEY => $errors, USERDTO_KEY => $newUser]);
            }
        }

        /**
         * Function for the login
         */
        public function login(){
            //Check if the user is logged in
            if(isLoggedIn()){
                redirect(INDEX_PAGE);
            }

            //preparing the error vector
            $errors = [
                EMAIL_KEY => '',
                'psw' => '',
            ];

            $newUser = new UserDTO;

            //Cheching the post request
            if($_SERVER[REQUEST_METHOD_KEY] == 'POST') {
                //Sanitize the POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Validate Email
                if(empty($_POST[EMAIL_KEY])) {
                    $errors[EMAIL_KEY] = 'Inserisci una email!';
                } else {
                    $newUser->setEmail($_POST[EMAIL_KEY]);
                }

                // Validate Password
                if(empty($_POST['psw'])) {
                    $errors['psw'] = 'Inserisci una password!';
                }
                else {
                    $newUser->setPsw($_POST['psw']);
                }

                //Check for user/email
                if(!$this->userModel->findUserByEmail($_POST[EMAIL_KEY])) {
                    $errors[EMAIL_KEY] = 'Utente non trovato!';
                }

                if(empty($errors[EMAIL_KEY]) && empty($errors['psw'])){
                    $loggedInUser = $this->userModel->existUserByEmailAndPswHash($newUser);

                    if($loggedInUser){
                        //Create the session
                        $this->createUserSession($loggedInUser);
                        redirect('');
                    } else {
                        $errors['psw'] = 'Password non corretta';
                        $this->view(LOGIN_PAGE, [ERRORS_KEY => $errors, USERDTO_KEY => $newUser]);
                    }
                }else{
                    $this->view(LOGIN_PAGE,[ERRORS_KEY => $errors, USERDTO_KEY => $newUser]);
                }
            }else{
                $this->view(LOGIN_PAGE,[ERRORS_KEY => $errors, USERDTO_KEY => $newUser]);
            }
        }

        /**
         * Function used to set all the session variable for the login
         * @param UserDTO $user the logged in user instance
         */
        public function createUserSession(UserDTO $user){
            $_SESSION[USERID_KEY] = $user->getId();
            $_SESSION['userEmail'] = $user->getEmail();
            $_SESSION['userFirstName'] = $user->getFirstName();
        }

        /**
         * Function used to unset all the session variable for the logout
         */
        public function logout(){
            unset($_SESSION[USERID_KEY]);
            unset($_SESSION['userEmail']);
            unset($_SESSION['userFirstName']);
            session_destroy();
            redirect(INDEX_PAGE);
        }

        /**
         * Function used to show all the user info
         */
        public function myProfile(){
            if(!isLoggedIn()){
                redirect(INDEX_PAGE);
            }

            //Getting all the user information
            $user = $this->userModel->getUserById($_SESSION[USERID_KEY]);
            $userAbilities = $this->abilityModel->getAbilitiesByUserId($_SESSION[USERID_KEY]);

            $this->view('users/myProfile',[USERDTO_KEY => $user, USER_ABILITIES_KEY => ((count($userAbilities) != 0) ? $userAbilities : null) ]);
        }

        /**
         * Function used to modify all the user information
         */
        public function editMyProfile(){
            if(!isLoggedIn()){
                redirect(INDEX_PAGE);
            }

            //preparing the error vector
            $errors = [
                FIRST_NAME_KEY => '',
                LAST_NAME_KEY => '',
                OLD_PSW_KEY => '',
                NEW_PSW_KEY => '',
                CONFIRM_PSW_KEY => ''
            ];

            //Getting all the user information
            $user = $this->userModel->getUserById($_SESSION[USERID_KEY]);
            $userAbilities = $this->abilityModel->getAbilitiesByUserId($_SESSION[USERID_KEY]);
            $allAbilities = $this->abilityModel->getAllAbilities();

            //Cheching the post request
            if($_SERVER[REQUEST_METHOD_KEY] == 'POST') {
                //Sanitize the POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $foundError = false;

                // Validate lastName
                if(isset($_POST[LAST_NAME_KEY]) && !empty($_POST[LAST_NAME_KEY])){
                    $user->setLastName($_POST[LAST_NAME_KEY]);
                } else {
                    $errors[LAST_NAME_KEY] = ENTER_SURNAME_ERROR;
                    $foundError = true;
                }

                // Validate firstName
                if(isset($_POST[FIRST_NAME_KEY]) && !empty($_POST[FIRST_NAME_KEY])){
                    $user->setFirstName($_POST[FIRST_NAME_KEY]);
                } else {
                    $errors[FIRST_NAME_KEY] = ENTER_NAME_ERROR;
                    $foundError = true;
                }

                $oldPsw = false;

                //Validate old_psw
                if(isset($_POST[OLD_PSW_KEY]) && !empty($_POST[OLD_PSW_KEY])){
                    $oldPsw = true;
                    if(strlen($_POST[OLD_PSW_KEY]) < 6){
                        $errors[OLD_PSW_KEY] = PSW_LENGTH_ERROR;
                        $foundError = true;
                    } else {
                        $user->setPsw($_POST[OLD_PSW_KEY]);
                        if (!$this->userModel->existUserByEmailAndPswHash($user)) {
                            //The password is not correct
                            $errors[OLD_PSW_KEY] = PSW_NOT_THE_SAME_ERROR;
                            $foundError = true;
                        }
                    }
                }

                if ($oldPsw){
                    //Validate new_psw
                    if(isset($_POST[NEW_PSW_KEY]) && !empty($_POST[NEW_PSW_KEY])){
                        if(strlen($_POST[NEW_PSW_KEY]) < 6){
                            $errors[NEW_PSW_KEY] = PSW_LENGTH_ERROR;
                            $foundError = true;
                        } else {
                            $user->setPsw($_POST[NEW_PSW_KEY]);
                        }
                    }else{
                        $errors[NEW_PSW_KEY] = 'Devi inserire una password!';
                        $foundError = true;
                    }

                    //Validate confirm_psw
                    if(isset($_POST[CONFIRM_PSW_KEY]) && !empty($_POST[CONFIRM_PSW_KEY])){
                        if(strlen($_POST[CONFIRM_PSW_KEY]) < 6){
                            $errors[CONFIRM_PSW_KEY] = PSW_LENGTH_ERROR;
                            $foundError = true;
                        } else {
                            if($_POST[NEW_PSW_KEY] != $_POST[CONFIRM_PSW_KEY]){
                                $errors[CONFIRM_PSW_KEY] = PSW_NOT_THE_SAME_ERROR;
                                $foundError = true;
                            }else{
                                $user->setPsw($_POST[NEW_PSW_KEY]);
                            }
                        }
                    }else{
                        $errors[CONFIRM_PSW_KEY] = 'Devi inserire la password di conferma!';
                        $foundError = true;
                    }
                }elseif (isset($_POST[NEW_PSW_KEY]) && !empty($_POST[NEW_PSW_KEY]) || isset($_POST[CONFIRM_PSW_KEY]) && !empty($_POST[CONFIRM_PSW_KEY])){
                    $errors[OLD_PSW_KEY] = 'Devi inserire la precedente password!';
                    $foundError = true;
                }

                if (!$foundError){
                    //Executing the query to send the data
                    //The selected Abilities are inside the $_POST['abilities'] with the id
                    if (!empty($user->getPsw())){
                        //Hashing the psw
                        $user->setPsw(password_hash($user->getPsw(),PASSWORD_BCRYPT));
                    }else {
                        $user->setPsw('');
                    }

                    //Executing the query to change the user info
                    $this->userModel->editUser($user);

                    //executing the query to change the abilities
                    $this->abilityModel->dropAllAlibitiesByUserId($user->getId());
                    foreach ($_POST['abilities'] as $ability){
                        $this->abilityModel->addAbilityToUser($ability,$user->getId());
                    }

                    //updating the session
                    $this->createUserSession($user);

                    flash('profile_edit_success', 'Modifiche apportate con successo!');
                    redirect('users/myProfile');

                }else{
                    $this->view('users/editMyProfile',[ERRORS_KEY => $errors, USERDTO_KEY => $user,"allAbilities" => $allAbilities, USER_ABILITIES_KEY => $userAbilities]);
                }


            }else{
                $this->view('users/editMyProfile',[ERRORS_KEY => $errors, USERDTO_KEY => $user,"allAbilities" => $allAbilities, USER_ABILITIES_KEY => $userAbilities]);
            }
        }

        public function getMembersList($ideaId, $teamId){
            $data = [USERDTO_KEY => [], TEAM_ID => $teamId, IDEA_ID => $ideaId, OWNER => false];
            $data[USERDTO_KEY] = $this->userModel->getUsersByTeamId($teamId);
            $data[OWNER] = $this->ideaModel->getIdeaById($ideaId)->getOwnerId() == $_SESSION[USER_ID];
            foreach($data[USERDTO_KEY] as $user){
                $request = $this->partecipationRequestModel->getPartecipationRequestByUserIdAndIdeaId($ideaId, $user->getId());
                $user->setReqId($request->getPartecipationRequestId());
            }
            $this->view("teams/members", $data);

        }

    }

