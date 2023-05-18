<?php

require_once __DIR__ . "/src/Bootstrapper.php";

use Physler\Session\SessionVisitor;

$user = SessionVisitor::GetActive()->GetVisitorUser();

if ($user == false) {
    header("Location: /");
    die;
}

?>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <link rel="manifest" href="/app.webmanifest">
    <script src="/pwa_init.js"></script>
    <title>PhysiRec</title>

    <meta name="theme-color" content="#0A0A0A"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/mat/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/mat/img/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/mat/img/android-chrome-512x512.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/mat/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/mat/img/favicon-16x16.png">

    <link href="/common/app/imports.css" rel="stylesheet" crossorigin="anonymous">

    <script>
        var user = <?php echo json_encode($user); ?>;
    </script>

    <!-- Custom styles for this template -->
    <!-- <link href="/api/render/css?env=app&name=complex.scss" rel="stylesheet"> -->
    <link rel="stylesheet" href="/common/vendor/sweetalert2/sweetalert2.min.css">

    <script src="/common/vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="/common/vendor/jquery/script.js"></script>
    <script src="/common/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="dark-mode not-shown ambient-lighting">
    <div class="loader">
        <div class="loader-content">
            <i class="fa fa-spinner-third fa-spin"></i>
            <div class="loader-context">Downloading content...</div>
        </div>
    </div>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand me-0 px-3 fs-6" href="#"><img width="120px" src="/mat/img/woosh.png" alt="PhysyRec Logo"></a>
        <ul class="pnav">
            <?php if ($user->GetUserRole() > G_STUDENT): ?>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/complex.php/dashboard" data-ajax="dashboard">
                    <i class="fas fa-house"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/complex.php/activity" data-ajax="activity">
                    <i class="fas fa-wave-pulse"></i>
                    Activity
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/complex.php/settings" data-ajax="settings">
                    <i class="fas fa-cogs"></i>
                    Preferences
                </a>
            </li>

            <li class="nav-item shine" hidefrom="installed">
                <a class="nav-link active" aria-current="page" href="/complex.php/install" data-ajax="install">
                    <i class="fas fa-download"></i>
                    Install
                </a>
            </li>
            <?php elseif ($user->GetUserRole() > G_TEACHER): ?>
                <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/complex.php/teachers/dashboard" data-ajax="teachers/dashboard">
                    <i class="fas fa-house"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/complex.php/teachers/students" data-ajax="teachers/students">
                    <i class="fas fa-screen-users"></i>
                    Students
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/complex.php/teachers/access" data-ajax="teachers/access">
                    <i class="fas fa-users-gear"></i>
                    Collaborators
                </a>
            </li>

            <?php if($user->GetUserRole() > G_SUPERUSER): ?>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/complex.php/admin/console" data-ajax="admin/console">
                    <i class="fas fa-user-shield"></i>
                    Superuser
                </a>
            </li>
            <?php endif; ?>

            <li class="nav-item shine" hidefrom="installed">
                <a class="nav-link active" aria-current="page" href="/complex.php/install" data-ajax="install">
                    <i class="fas fa-download"></i>
                    Install
                </a>
            </li>
            <?php endif; ?>
        </ul>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap mx-2">
                <span class="me-1"><?= $user->display_name ?></span>
                <img class="rounded" width="25px" src="<?= $user->profile_picture ?>" alt="Google Profile Picture">     
            </div>
        </div>
    </header>

    <div class="scroll-container">
        <div class="row">
            <main class="col-md-9 px-md-4 page-shown mx-auto" id="ajax-container">

            </main>
        </div>
        <div class="fixed-bottom mobile-navbar-bg">
            <div class="mobile-navbar">
                <button class="nav-btn active" data-ajax="dashboard" aria-label="Home"><i class="fa-home"></i></button>
                <button class="nav-btn" data-ajax="activity" aria-label="Activity"><i class="fa-wave-pulse"></i></button>
                <button class="nav-btn" data-ajax="settings" aria-label="Preferences"><i class="fa-cogs"></i></button>
            </div>
        </div>
    </div>

    <script src="/common/vendor/feather-icons/dist/feather.min.js"></script>
    <script src="/common/vendor/chart-js/dist/chart.min.js"></script>
    <script src="/common/app/complex.js"></script>
    <!-- <script src="/common/vendor/duration-picker/out.js"></script> -->
</body>

</html>