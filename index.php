<?php

require( __DIR__ . "/src/Bootstrapper.php" );

use Phylser\Controller\Api\ApiController;
use Phylser\Controller\Api\BaseController;
use Physler\Db\DbClient;
use Physler\GoogleApi\OAuth2\Client\OAuth2;
use Physler\GoogleApi\OAuth2\Client\Scopes\OAuth2Api;
use Physler\GoogleApi\OAuth2\Client\Scopes\ScopeBuilder;
use Physler\Session\SessionVisitor;

$sm = SessionVisitor::Start();

if (!$sm->GetVisitorUser()) {

	$url = OAuth2::CreateUrl([
		SCOPE => new ScopeBuilder([OAuth2Api::EMAIL_ADDRESS]),
		REDIRECT_URI => 'https://'.$_SERVER['HTTP_HOST']."/api.php/gauth/callback"
	]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="manifest" href="app.webmanifest">
	<script src="pwa_init.js"></script>
	<script src="/common/vendor/jquery/script.js"></script>
	<title>PhysiRec</title>
	<link rel="stylesheet" href="/common/app/imports.css">
	<link rel="stylesheet" href="/common/app/splash.css">
	<link rel="stylesheet" href="/common/element/spinner.css">
</head>
<body>
	<div class="flex-box">
		<div class="splash-screen">
			<div class="splash-app-logo">
				<img src="/mat/img/woosh.png">
			</div>
			<?php if (!$sm->GetVisitorUser()): ?>
			<div class="splash-element splash-app-introduce-login">
				<a href="<?=$url?>">Login</a>
			</div>
			<?php else: ?>
			<div class="splash-element splash-app-introduce-login">
				<div class="spinner" style="--hspinner-default-size: 50px;">
					<div class="bar1"></div>
					<div class="bar2"></div>
					<div class="bar3"></div>
					<div class="bar4"></div>
					<div class="bar5"></div>
					<div class="bar6"></div>
					<div class="bar7"></div>
					<div class="bar8"></div>
					<div class="bar9"></div>
					<div class="bar10"></div>
					<div class="bar11"></div>
					<div class="bar12"></div>
				</div>
			</div>
			<script>
				setTimeout(() => {					
					let t = 100;
					var ticker = setInterval(() => {
						t--;
						document.body.style.opacity = t/100;
						if (t < 0) {
							clearInterval(ticker);
							window.location = "app.php";
						}
					}, 1)
				}, 2000);
			</script>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>