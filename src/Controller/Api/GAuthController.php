<?php

namespace Phylser\Controller\Api;

use Physler\GoogleApi\Auth\Server\OAuth2\OAuth2;
use Physler\GoogleApi\Http\BaseUri;
use Physler\GoogleApi\Http\HttpClient;
use Physler\Session\SessionVisitor;

$sesh = SessionVisitor::GetActive();

class GAuthController extends BaseController {
    /**
     * "/gauth/callback" Endpoint
     * - Callback from Google OAuth2
     */
    public function callback() {
        global $sesh;
        $strErrorDesc = '';
        $method = $this->getRequestMethod();
        $argq = $this->getQueryStringParams();

        if ($method == 'GET') {
            $sesh->SetVar("email", "test");
            header("Location: /");
        }
    }
}