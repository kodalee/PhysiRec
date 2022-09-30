<?php

namespace Physler\Session;

class SessionBase {
    public $session = [];
    public function __construct() {
        if ( !ISSET($_SESSION) ) {
            session_start();
    
            if ( !ISSET($_SESSION) ) {
                throw new Exception\SessionStartException("ISSET(\$_SESSION) is not true.");
            }
        }
        $this->session = $_SESSION;
    }

    /**
     * Get an active session pointer.
     * @return \Physler\Session\SessionBase
     */
    public static function GetActive() {
       return new SessionBase();
    }

    /**
     * Set a session variable
     * @param string $param Parameter of a session variable.
     * @param mixed $value Value for the variable
     */
    public function SetVar($param, $value) {
        $_SESSION[$param] = $value;
    }
    
    /**
     * Get a session variable without getting errors
     *                for entering an undefined one!
     * @param string $param
     * @return mixed|null Will return null if the parameter is undefined.
     */
    public function GetVar($param) {
        if ( ISSET($_SESSION[$param]) ) {
            return $_SESSION[$param];
        }
        else {
            return null;
        }
    }
}