<?php

namespace Physler\Db\Exception;

use Exception;

class QueryErrorException extends Exception {
    public $message = "Message not given";
    public $address = "0.0.0.0:1000";
    public $errno = 0;

    public function __construct($address, $message, $connect_error = NULL) 
    {
        parent::__construct($message);
    }

    public function what() {
        return "Connection OK, query failure to Sql Database at given address {$this->address}. \"Reason: {$this->message}\"";
    }

    public function __toString() {
        return "[" . __CLASS__ . "\\{$this->code}]: " . $this->what();
    }
}