<?php

namespace Physler\Controller\Api;

use Physler\Session\SessionVisitor;

$sesh = SessionVisitor::GetActive();

class UserController extends BaseController {
    public function editSettings() {
        global $sesh;
    }

    public function activities() {
        global $sesh;
        $strErrorDesc = '';
        $method = $this->getMethod();
        $segments = $this->getSegments();
        
        if ($method == 'POST') {
            $activity = $_POST["activity"];
            $explanation = $_POST["explanation"];
            $duration = $_POST["duration"];
            $time = $_POST["time"];
            
            $sesh->GetVisitorUser()->AddActivity($activity, $explanation, $duration, $time);
            $this->outputJson(["success" => true, "requestData" => $_POST]);
        }
    }

    public function heartbeat() {
        global $sesh;
        $strErrorDesc = '';
        $method = $this->getMethod();
        $segments = $this->getSegments();
        
        if ($method == 'POST') {
            $activity = $_POST["activity"];
            $bpm = $_POST["bpm"];
            
            $sesh->GetVisitorUser()->LogHeartbeat($activity, $bpm);
            $this->outputJson(["success" => true, "requestData" => $_POST]);
        }
    }
}