<?php
    //
    session_start();
    define("CLASS_ATT", '_class');
    define('USER_ID','userId');
    //Flash message helper
    function flash($name = '', $message = '', $class = 'alert alert-success'){
        if(!empty($name) && !empty($message)){
        if(!empty($_SESSION[$name])){
           unset($_SESSION[$name]);
        }

        if(!empty($_SESSION[$name . CLASS_ATT])){
            unset($_SESSION[$name . CLASS_ATT]);
        }

        $_SESSION[$name] = $message;
        $_SESSION[$name.CLASS_ATT] = $class;

        } elseif(empty($message) && !empty($_SESSION[$name])){
            $class = !empty($_SESSION[$name . CLASS_ATT]) ? $_SESSION[$name . CLASS_ATT] : "alert alert-success";
            $message = $_SESSION[$name];
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name. CLASS_ATT]);
        }
    }

    function isLoggedIn(){
        return isset($_SESSION[USER_ID]);
    }