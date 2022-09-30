<?php

namespace Physler\Db\Exception;

use Exception;

class ConnectErrorException extends Exception {
    public $address = "0.0.0.0:1000";

    public function __construct($address, $message) 
    {
        $this->address = $address;
        parent::__construct($message);
    }

    public function what() {
        return "Failure to connect to Sql Database at given address {$this->address}. Reason: \"{$this->message}\"";        
    }

    public function __toString() {
        return __CLASS__ . ": " . $this->what();
    }
}