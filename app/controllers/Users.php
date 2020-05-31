<?php

    class Users extends Controller{
        private $userModel;
        private $abilityModel;

        public function __construct(){

            //Importing the user model
            $this->model('User');
            //Creating the UserModel Pojo instance
            $this->userModel = new User;

            //Importing the ability model
            $this->model('Ability');
            //Creating the UserModel Pojo instance
            $this->abilityModel = new Ability;
        }

        //Function for the signUp
        public function signUp(){
            //Check if the user is logged in
            if(isLoggedIn()){
                redirect('pages/index');
            }

            //preparing the error vector
            $errors = [
                'firstName' => '',
                'lastName' => '',
                'email' => '',
                'psw' => '',
                'confirm_psw' => ''
            ];

            $newUser = new UserDTO;

            //Cheching the post request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Sanitize the POST data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

                $foundError = false;

                //Validating the email
                if(isset($_POST['email']) && !empty($_POST['email'])){
                    // Check email
                    if($this->userModel->findUserByEmail($_POST['email'])){
                        $errors['email'] = 'Email is already taken';
                        $foundError = true;
                    }
                    $newUser->setEmail($_POST['email']);
                } else{
                    $errors['email'] = 'Pleae enter email';
                    $foundError = true;
                }

                // Validate lastName
                if(isset($_POST['lastName']) && !empty($_POST['lastName'])){
                    $newUser->setLastName($_POST['lastName']);
                } else {
                    $errors['lastName'] = 'Pleae enter name';
                    $foundError = true;
                }

                // Validate firstName
                if(isset($_POST['firstName']) && !empty($_POST['firstName'])){
                    $newUser->setFirstName($_POST['firstName']);
                } else {
                    $errors['firstName'] = 'Pleae enter name';
                    $foundError = true;
                }

                // Validate Password
                if(isset($_POST['psw']) && !empty($_POST['psw'])){
                    if(strlen($_POST['psw']) < 6){
                        $errors['psw'] = 'Password must be at least 6 characters';
                        $foundError = true;
                    } else $newUser->setPsw($_POST['psw']);
                } else {
                    $errors['psw'] = 'Pleae enter password';
                    $foundError = true;
                }

                // Validate Confirm Password
                if(isset($_POST['psw']) && !empty($_POST['psw'])){
                    if($_POST['psw'] != $_POST['confirm_psw']) {
                        $errors['confirm_psw'] = 'Passwords do not match';
                        $foundError = true;
                    }
                } else {
                    $errors['confirm_psw'] = 'Pleae confirm password';
                    $foundError = true;
                }

                //Creating the user only if no errors found
                if(!$foundError){

                    //Hashing the psw
                    $newUser->setPsw(password_hash($newUser->getPsw(),PASSWORD_BCRYPT));

                    //Inserting the user into the database
                    if($this->userModel->createUser($newUser)){
                        flash('register_success', 'You are registered and can log in');
                        redirect('users/login');
                    } else die("Something wenting wrong!");
                }else{
                    //I'm here becouse i've found some errors
                    //Loading the view with the errors
                    $this->view('users/signUp',["errors" => $errors, "userDTO" => $newUser]);
                }
            } else {
                $this->view('users/signUp',["errors" => $errors, "userDTO" => $newUser]);
            }
        }

        //Function for the login
        public function login(){
            //Check if the user is logged in
            if(isLoggedIn()){
                redirect('pages/index');
            }

            //preparing the error vector
            $errors = [
                'email' => '',
                'psw' => '',
            ];

            $newUser = new UserDTO;

            //Cheching the post request
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Sanitize the POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Validate Email
                if(empty($_POST['email']))  $errors['email'] = 'Pleae enter email';
                else $newUser->setEmail($_POST['email']);

                // Validate Password
                if(empty($_POST['psw'])) $errors['psw'] = 'Please enter password';
                else $newUser->setPsw($_POST['psw']);

                //Check for user/email
                if(!$this->userModel->findUserByEmail($_POST['email'])) $errors['email'] = 'No user found';

                if(empty($errors['email']) && empty($errors['psw'])){
                    $loggedInUser = $this->userModel->existUserByEmailAndPswHash($newUser);

                    if($loggedInUser){
                        //Create the session
                        $this->createUserSession($loggedInUser);
                        redirect('');
                    } else {
                        $errors['psw'] = 'Password incorrect';
                        $this->view('users/login', ["errors" => $errors, "userDTO" => $newUser]);
                    }
                }else{
                    $this->view('users/login',["errors" => $errors, "userDTO" => $newUser]);
                }
            }else{
                $this->view('users/login',["errors" => $errors, "userDTO" => $newUser]);
            }
        }

        /**
         * Function used to set all the session variable for the login
         * @param UserDTO $user the logged in user instance
         */
        public function createUserSession(UserDTO $user){
            $_SESSION['userId'] = $user->getId();
            $_SESSION['userEmail'] = $user->getEmail();
            $_SESSION['userFirstName'] = $user->getFirstName();
        }

        /**
         * Function used to unset all the session variable for the logout
         */
        public function logout(){
            unset($_SESSION['userId']);
            unset($_SESSION['userEmail']);
            unset($_SESSION['userFirstName']);
            session_destroy();
            redirect('pages/index');
        }

        /**
         * 
         */
        public function myProfile(){
            if(!isLoggedIn()){
                redirect('pages/index');
            }

            //Getting all the user information
            $user = $this->userModel->getUserById($_SESSION['userId']);
            $userAbilities = $this->abilityModel->getAbilitiesByUserId($_SESSION['userId']);

            $this->view('users/myProfile',["userDTO" => $user, "userAbilities" => ((count($userAbilities) != 0) ? $userAbilities : null) ]);
        }

        /**
         *
         */
        public function editMyProfile(){
            if(!isLoggedIn()){
                redirect('pages/index');
            }

            //preparing the error vector
            $errors = [
                'firstName' => '',
                'lastName' => '',
                'old_psw' => '',
                'new_psw' => '',
                'confirm_psw' => ''
            ];

            //Getting all the user information
            $user = $this->userModel->getUserById($_SESSION['userId']);
            $userAbilities = $this->abilityModel->getAbilitiesByUserId($_SESSION['userId']);
            $allAbilities = $this->abilityModel->getAllAbilities();

            //Cheching the post request
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Sanitize the POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $foundError = false;

                // Validate lastName
                if(isset($_POST['lastName']) && !empty($_POST['lastName'])){
                    $user->setLastName($_POST['lastName']);
                } else {
                    $errors['lastName'] = 'Pleae enter name';
                    $foundError = true;
                }

                // Validate firstName
                if(isset($_POST['firstName']) && !empty($_POST['firstName'])){
                    $user->setFirstName($_POST['firstName']);
                } else {
                    $errors['firstName'] = 'Pleae enter name';
                    $foundError = true;
                }

                $oldPsw = false;
                $newPsw = false;

                //Validate old_psw
                if(isset($_POST['old_psw']) && !empty($_POST['old_psw'])){
                    if(strlen($_POST['old_psw']) < 6){
                        $errors['old_psw'] = 'Password must be at least 6 characters';
                        $foundError = true;
                    } else {
                        $user->setPsw($_POST['old_psw']);
                        if (!$this->userModel->existUserByEmailAndPswHash($user)){
                            //The password is not correct
                            $errors['old_psw'] = "Password do not match!";
                            $foundError = true;
                        }else $oldPsw = true;
                    }
                }

                if ($oldPsw){
                    //Validate new_psw
                    if(isset($_POST['new_psw']) && !empty($_POST['new_psw'])){
                        if(strlen($_POST['new_psw']) < 6){
                            $errors['new_psw'] = 'Password must be at least 6 characters';
                            $foundError = true;
                        } else {
                            $user->setPsw($_POST['new_psw']);
                        }
                    }else{
                        $errors['new_psw'] = 'You must insert a new password!';
                        $foundError = true;
                    }

                    //Validate confirm_psw
                    if(isset($_POST['confirm_psw']) && !empty($_POST['confirm_psw'])){
                        if(strlen($_POST['confirm_psw']) < 6){
                            $errors['confirm_psw'] = 'Password must be at least 6 characters';
                            $foundError = true;
                        } else {
                            if($_POST['new_psw'] != $_POST['confirm_psw']){
                                $errors['confirm_psw'] = "Passwords do not match!";
                                $foundError = true;
                            }else{
                                $user->setPsw($_POST['new_psw']);
                            }
                        }
                    }else{
                        $errors['confirm_psw'] = 'You must insert the confirm password!';
                        $foundError = true;
                    }
                }

                if (!$foundError){
                    //Executing the query to send the data
                    //The selected Abilities are inside the $_POST['abilities'] with the id
                    if (!empty($user->getPsw())){
                        //Hashing the psw
                        $user->setPsw(password_hash($user->getPsw(),PASSWORD_BCRYPT));
                    }else $user->setPsw('');

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
                    $this->view('users/editMyProfile',["errors" => $errors, "userDTO" => $user,"allAbilities" => $allAbilities, "userAbilities" => $userAbilities]);
                }


            }else{
                $this->view('users/editMyProfile',["errors" => $errors, "userDTO" => $user,"allAbilities" => $allAbilities, "userAbilities" => $userAbilities]);
            }
        }
    }

?>