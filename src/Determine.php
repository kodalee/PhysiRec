<?php

namespace Physler;

use Physler\Session\SessionBase;
use Physler\Session\SessionVisitor;
use Physler\User\User;

class Determine {
    const LOCALHOST = [
        '127.0.0.1',
        '::1'
    ];
    public static function CAN_VIEW_TRACE() {
        // Allow viewing of the stack trace if localhost
        if( IN_ARRAY($_SERVER["REMOTE_ADDR"], Determine::LOCALHOST) ){
            return true;
        }

        // If the user is a developer or superuser than allow trace access.
        $user = SessionVisitor::GetActive()->GetVisitorUser();
        return ( $user != FALSE ) ? $user->IsSuperuser() : FALSE;
    }
}