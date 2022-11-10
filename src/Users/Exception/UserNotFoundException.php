<?php

namespace Physler\User\Exception;

use Exception;

class UserNotFoundException extends Exception {
    public $email;

    public function __construct($email, $message) 
    {
        $this->email = $email;
        parent::__construct($message);
    }

    public function what() {
        return "The user under the entered email address {$this->email} doesn't exist but the user was still signed in? {$this->message}";        
    }

    public function __toString() {
        return __CLASS__ . ": " . $this->what();
    }
}