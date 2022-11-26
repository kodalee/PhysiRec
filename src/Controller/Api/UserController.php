<?php

namespace Physler\Controller\Api;

use Physler\Session\SessionVisitor;

$sesh = SessionVisitor::GetActive()->GetVisitorUser();

class UserController extends BaseController {
    public function editSettings() {
        global $sesh;
    }
}