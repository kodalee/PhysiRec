<?php

namespace Physler\Session;

use Physler\User\User;
 
class SessionVisitor extends SessionBase {
    public function __construct()
    {
        parent::__construct();
    }

    public static function Start() {
        return new SessionVisitor();
    }

    /**
     * Get an active session pointer for SessionVisitor
     * @return \Physler\Session\SessionVisitor
     */
    public static function GetActive() {
        return new SessionVisitor();
     } 

    /**
     * Get the visitor's user
     * @return \Physler\User\User|false
     *      Will return user if it exists, otherwise,
     *               it will return false
     * @throws \Physler\Session\Exception\SessionStartException
     *      If there was an issue starting the session
     *    like if a debugger was present, it won't start.
     * @throws \Physler\User\Exception\UserNotFoundException
     *      If the user that is requested doesn't exist
     *         it will throw this exception without
     *        catching it because it shouldn't happen
     */
    public function GetVisitorUser() {
        if ( $this->GetVar("email") == NULL ) {
            return false;
        }

        return User::GetByEmail( $this->GetVar("email"), false );
    }

    public function Kill() {
        return session_destroy();
    }
}

