<?php

namespace Physler\Session\Exception;

use Exception;

class SessionStartException extends Exception {
    public function __construct($message) 
    {
        parent::__construct($message);
    }

    public function what() {
        return "Failure to create a session! {$this->message}";        
    }

    public function __toString() {
        return __CLASS__ . ": " . $this->what();
    }
}