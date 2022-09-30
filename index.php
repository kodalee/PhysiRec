<?php

require( __DIR__ . "/src/Main.php" );

use Physler\Db\DbClient;
use Physler\GoogleApi\Auth\Client\OAuth2\OAuth2;
use Physler\GoogleApi\Auth\Client\OAuth2\Scopes\OAuth2Api;
use Physler\GoogleApi\Auth\Client\OAuth2\Scopes\ScopeBuilder;
use Physler\Session\SessionVisitor;

$sm = SessionVisitor::Start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PhysiRec</title>
</head>
<body>
	<?php

	$url = OAuth2::CreateUrl()
	->SetScopes(new ScopeBuilder([OAuth2Api::EMAIL_ADDRESS]))
	->SetClientId("62631792304-59mit2gahkh43094prti6p493vnf3gad.apps.googleusercontent.com")
	->SetRedirectUri("http://localhost/test.php");

	$connection = DbClient::Init([
		"serveraddr" => "127.0.0.1:3306",
		"username" => "physler",
		"password" => "kodabear12"
	]);
	
	$db_sql = $connection->SelectDb("mysql");

	var_dump(strval($url));

	?>
</body>
</html>