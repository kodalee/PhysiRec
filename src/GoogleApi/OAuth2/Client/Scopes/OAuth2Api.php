<?php

namespace Physler\GoogleApi\OAuth2\Client\Scopes;

enum OAuth2Api {
    const EMAIL_ADDRESS = "/auth/userinfo.email";
    const PROFILE = "/auth/userinfo.profile";
    const OPENID = "openid";
}
