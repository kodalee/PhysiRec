<?php

namespace Physler\User\Exception;

use Exception;

class UserNotFoundException extends Exception {
    public $username;

    public function __construct($username, $message) 
    {
        $this->username = $username;
        parent::__construct($message);
    }

    public function what() {
        return "The user under the entered email address doesn't exist. {$this->message}";        
    }

    public function __toString() {
        return __CLASS__ . ": " . $this->what();
    }
}