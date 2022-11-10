<?php

require( __DIR__ . "/src/Bootstrapper.php" );
use Physler\Session\SessionVisitor;

use function Physler\is_app_hang;

$sm = SessionVisitor::Start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="manifest" href="app.webmanifest">
	<link rel="apple-touch-icon" href="/mat/img/512.png">

	<script src="pwa_init.js"></script>
	<script src="/common/vendor/jquery/script.js"></script>
	<title>PhysiRec</title>
	<link rel="stylesheet" href="/common/app/imports.css">
	<link rel="stylesheet" href="/common/app/splash.css">
	<link rel="stylesheet" href="/common/models/spinner.css">
</head>
<body>
	<div class="flex-box">
		<div class="splash-screen">
			<div class="splash-stuff">
				<div class="splash-app-logo">
					<img src="/mat/img/woosh.png">
				</div>
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
			</div>
			<script>
				<?php if (is_app_hang()): ?>
				setTimeout(() => {
					$.get("/api.php/status")
					.then(res => {
						$.get("/api.php/gauth/login").then(res => {
							if (res.login_required) {
								window.location = res.url;
							} else {
								window.location = "complex.php";
							}
						})
					})
					.catch(err => {
						window.location = "/common/errors/generic_no_internet.html";
					})
				}, 4000);
				<?php endif; ?>
			</script>
		</div>
	</div>
</body>
</html>