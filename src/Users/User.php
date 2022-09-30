<?php

namespace Physler\User;

class User {
    /** @var int */
    public $id;
    /** @var string */
    public $username;
    /** @var string */
    public $display_name;
    /** @var string */
    public $email_address;
    /** @var array */
    protected $user_groups;
    /** @var string */
    private $session_tok;

    public function __construct() {
        
    }

    public static function GetByName($username) {
        throw new Exception\UserNotFoundException($username, PHYS_E_USER_SESSION);
    }

    public function ValidatePasswd($input) {

    }

    public function GetUserGroups() {
        return $this->user_groups;
    }

    public function IsTeacher() {
        // if ( IN_ARRAY($this->GetUserGroups(), ) )
    }

    public function IsStudent() {

    }
    
    public function IsSuperuser() {
        return false;
    }
}