<?php

/**
 * Welcome to Physler!
 * WARNING: This software is not even ready for beta testing,
 * if you gained access to a copy of this software, you are free
 * to edit it how ever you'd like but do not expect a working
 * product.
 * 
 * You may not use this software in a proprietary environment
 * without my permission, for more information, read the LICENSE.md
 * 
 * github.com/hellokoda
 * me@koda.life
 * hellokodalee@gmail.com
 */

const __REQUIRES = [
    "/Config.php",
    "/functions.php",
    "/constants.php",
    "/Users/User.php",
    "/Users/Exception/UserNotFoundException.php",
    "/Determine.php",
    "/Sessions/SessionBase.php",
    "/Sessions/SessionVisitor.php",
    "/Sessions/Exception/SessionStartException.php",
    "/Db/DbClient.php",
    "/Db/Exception/ConnectErrorException.php",
    "/Db/Exception/QueryErrorException.php",
    "/GoogleApi/OAuth2/Client/OAuth2.php",
    "/GoogleApi/OAuth2/Client/OAuth2Url.php",
    "/GoogleApi/OAuth2/Client/Scopes/OAuth2Api.php",
    "/GoogleApi/OAuth2/Client/Scopes/ScopeBuilder.php",
    "/GoogleApi/OAuth2/Server/OAuth2.php",
    "/GoogleApi/Http/HttpClient.php",
    "/Controller/Api/BaseController.php",
    "/Controller/Api/ApiController.php",
    "/Controller/Api/GAuthController.php",
    "/BadThingHandler.php"
];

for ($i = 0; $i < COUNT( __REQUIRES ); $i++) { 
    require_once(__DIR__ . __REQUIRES[$i]);
}

Physler\BadThingHandler::Register();
// created by @hellokoda on github with love ❤ 2022 / 2023
?>