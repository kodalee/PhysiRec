<?php

namespace Physler;

class BadThingHandler {
    public function __construct() {
        if ( Determine::CAN_VIEW_TRACE() == TRUE ) {
            @set_exception_handler(null);
        }
        else {
            @set_exception_handler([$this, 'Issue']);
        }
    }

    static function Register() {
        return new BadThingHandler();
    }
    
    /**
     * @param Throwable $exception
     */
    public function Issue($exception) {
        echo(nl2br("There was an issue, contact an administrator about this issue. This issue should be logged for them."));
        return;
    }
}