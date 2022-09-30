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
    "/functions.php",
    "/constants.php",
    "/Users/User.php",
    "/Users/Exception/UserNotFoundException.php",
    "/Config.php",
    "/Determine.php",
    "/Sessions/SessionBase.php",
    "/Sessions/SessionVisitor.php",
    "/Sessions/Exception/SessionStartException.php",
    "/Db/DbClient.php",
    "/Db/Exception/ConnectErrorException.php",
    "/Db/Exception/QueryErrorException.php",
    "/GoogleApi/Auth/Client/OAuth2/OAuth2.php",
    "/GoogleApi/Auth/Client/OAuth2/Scopes/OAuth2Api.php",
    "/GoogleApi/Auth/Client/OAuth2/Scopes/ScopeBuilder.php",
    "/BadThingHandler.php"
];

for ($i = 0; $i < COUNT( __REQUIRES ); $i++) { 
    require_once(__DIR__ . __REQUIRES[$i]);
}

Physler\BadThingHandler::Register();
// created by @hellokoda on github with love ❤ 2022 / 2023
?>