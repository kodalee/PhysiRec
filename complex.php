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

    <link rel="manifest" href="app.webmanifest">
    <script src="pwa_init.js"></script>
    <title>PhysiRec</title>

    <link href="/common/app/imports.css" rel="stylesheet" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        ul.pnav {
            padding: 0;
            list-style: none;
            display: flex;
            flex-direction: row;
            margin: 0 auto;
            margin-left: 0;
        }

        .pnav .nav-link {
            transition: .2s;
            background: transparent;
            border: 1px solid transparent;
            padding: 10px 20px;
        }

        .pnav .nav-link:hover {
            background: #ffffff1b;
            border: 1px solid #ffffff55;
            border-radius: 1rem;
        }

        .pnav li.nav-item {
            margin: 0 20px;
        }

        .pnav .nav-link.active {
            border-radius: 1rem;
            border: 1px solid #1e6aff75;
            background: #1e6aff05;
            color: #6595f2;
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="/api.php/render/css?env=app&name=complex.scss" rel="stylesheet">

    <script src="/common/vendor/jquery/script.js"></script>
    <script src="/common/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="dark-mode not-shown ambient-lighting">
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#"><img width="120px" src="/mat/img/woosh.png"></a>
        <ul class="pnav">
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
        </ul>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap mx-2">
                <span class="me-1"><?= $user->display_name ?></span>
                <img class="rounded" width="25px" src="<?= $user->profile_picture ?>">
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
                <button class="nav-btn active" data-ajax="dashboard"><i class="fa-home"></i></button>
                <button class="nav-btn" data-ajax="activity"><i class="fa-wave-pulse"></i></button>
                <button class="nav-btn" data-ajax="settings"><i class="fa-cogs"></i></button>
            </div>
        </div>
    </div>

    <script src="/common/vendor/feather-icons/dist/feather.min.js"></script>
    <script src="/common/vendor/chart-js/dist/chart.min.js"></script>
    <script src="/common/app/complex.js"></script>
    <script src="/common/vendor/duration-picker/out.js"></script>
</body>

</html>