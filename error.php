<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="manifest" href="app.webmanifest">
	<script src="pwa_init.js"></script>
	<title>PhysiRec</title>

    <link rel="stylesheet" href="/common/app/imports.css">
	<link rel="stylesheet" href="/common/app/splash.css">
	<link rel="stylesheet" href="/common/models/spinner.css">
</head>
<body>
	<div class="flex-box">
		<div class="splash-screen">
			<div class="splash-app-logo">
				<img src="/mat/img/woosh.png">
			</div>
			<div class="splash-element text-danger">
                <?= $_GET["message"] ?>
			</div>
		</div>
	</div>
</body>
</html>