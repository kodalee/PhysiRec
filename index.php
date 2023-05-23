<?php

require( __DIR__ . "/src/Bootstrapper.php" );
use Physler\Session\SessionVisitor;

use function Physler\do_splash_animation;
use function Physler\is_app_hang;

$sm = SessionVisitor::Start();
$u = $sm->GetVisitorUser();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="manifest" href="/app.webmanifest">

	<link rel="apple-touch-icon" sizes="180x180" href="/mat/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/mat/img/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/mat/img/android-chrome-512x512.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/mat/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/mat/img/favicon-16x16.png">

	<script src="/pwa_init.js"></script>
	<script src="/common/vendor/jquery/script.js"></script>
	<title>PhysiRec</title>
	<link rel="stylesheet" href="/common/app/imports.css">
	<link rel="stylesheet" href="/common/app/splash.css">
	<link rel="stylesheet" href="/common/models/spinner.css">
</head>
<body class="<?= do_splash_animation()? "ready" : "" ?>">
	<div class="flex-box">
		<div class="bottom-info">
			<?php if ($u != false): ?>
				<?php
					switch ($u->GetUserRole()) {
						case G_SUPERUSER:
							echo "Superuser";
							break;
						case G_TEACHER:
							echo "Teacher";
							break;
						case G_STUDENT:
							echo "Student";
							break;
					}
				?> Logged In
				<br>
				User: <?= $u->display_name ?> (<?= $u->email ?>) 
			<?php else: ?>
				Unauthenticated
			<?php endif; ?>
			<br>
			<?= GH_REPO_COMMIT_INFO ?>
		</div>
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
				<div class="logo-sub">
					<div class="company-logo">
						<img src="https://gecs.org/wp-content/uploads/2020/07/gecs-logo-2020-72.png">
					</div>
				</div>
			</div>
			<script>
				<?php if (is_app_hang()): ?>


					
				$.get("/api/status")
				.then(res => {
					$.get("/api/gauth/login").then(res => {
						if (res.login_required) {
							window.location = res.url;
						} else {
							document.querySelector(".splash-app-logo img").classList.add("active")
							setTimeout(() => {
								document.body.classList.add("ready")
							}, 1000)
							setTimeout(() => {
								window.location = "complex.php";
							}, 4000);
						}
					})
				})
				.catch(err => {
					window.location = "/common/errors/generic_no_internet.html";
				})
				<?php endif; ?>
			</script>
		</div>
	</div>
</body>
</html>