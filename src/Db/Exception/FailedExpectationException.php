<?php

namespace Physler\Db\Exception;

use Exception;

class FailedExpectationException extends Exception {
    public function __construct($expectation) 
    {
        parent::__construct($expectation);
    }

    public function what() {
        return "Expectations were not met when a query was handled. Expectation was as follows: {$this->message}";
    }

    public function __toString() {
        return __CLASS__ . ": " . $this->what();
    }
}