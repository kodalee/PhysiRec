<?php

namespace Physler\Controller\Api;

use Physler\Config;
use Physler\GoogleApi\Http\BaseUri;
use Physler\GoogleApi\Http\GoogleClient;
use Physler\GoogleApi\Http\HttpClient;
use Physler\GoogleApi\OAuth2\Client\OAuth2;
use Physler\GoogleApi\OAuth2\Client\Scopes\OAuth2Api;
use Physler\GoogleApi\OAuth2\Client\Scopes\ScopeBuilder;
use Physler\Session\SessionVisitor;
use Physler\User\User;

$sesh = SessionVisitor::GetActive();

class GAuthController extends BaseController {
    /**
     * "/gauth/callback" Endpoint
     * - Callback from Google OAuth2
     */
    public function callback() {
        global $sesh;
        $strErrorDesc = '';
        $method = $this->getMethod();
        $argq = $this->getQuery();

        if ($method == 'GET') {
            $googleClient = new GoogleClient();
            $googleUser = $googleClient->ExchangeTokens($argq["code"]);

            $guser = $googleUser->GetUserInfo();

            if (!ISSET($guser->hd) || $guser->hd != Config::EDU_EMAIL_SUFFIX) {
                header("Location: /common/errors/generic_user_not_allowed.html");
            }

            $user = User::GetByEmail($guser->email, true);

            if ($user == false) {
                User::MakeUser(
                    $guser->email,
                    $guser->picture,
                    [
                        "first" => $guser->given_name,
                        "last" => $guser->family_name
                    ],
                    $guser->locale
                );
            }

            $sesh->SetVar("email", $guser->email);
            header("Location: /");
        }
    }
    /**
     * "/gauth/kill" Endpoint
     * - Kill the session
     */
    public function kill() {
        global $sesh;
        $strErrorDesc = '';
        $method = $this->getMethod();
        $argq = $this->getQuery();

        if ($method == 'GET') {
            $sesh->Kill();
            header("Location: /");
        }
    }

    /**
     * "/gauth/firsttime" Endpoint
     * - Check if its the users first time using PhysiRec
     */
    public function firsttime() {
        global $sesh;
        $strErrorDesc = '';
        $method = $this->getMethod();
        $argq = $this->getQuery();

        if ($method == 'GET') {
            $this->outputJson(["firsttime" => true]);
        }        
    }
    
    public function login() {
        global $sesh;
        $strErrorDesc = '';
        $method = $this->getMethod();
        $argq = $this->getQuery();

        if ($method == 'GET') {
            if ($sesh->GetVisitorUser() == false) {
                $uriData = OAuth2::CreateUrl([
                    SCOPE => new ScopeBuilder([OAuth2Api::EMAIL_ADDRESS, OAuth2Api::PROFILE]),
                    REDIRECT_URI => 'https://'.$_SERVER['HTTP_HOST']."/api.php/gauth/callback",
                    PROMPT => join(" ", [CONSENT, SELECT_ACCOUNT])
                ]);
                $this->outputJson([
                    "url" => strval($uriData),
                    "uri" => $uriData,
                    "login_required" => true
                ]);
            }
            else {
                $this->outputJson([
                    "login_required" => false
                ]);
            }
        }
    }
}