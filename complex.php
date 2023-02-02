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
        }

        .pnav .nav-link {
            transition: .2s;
            background: transparent;
            border: 1px solid transparent;
            padding: 5px 20px;
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

        .nav-item.shine:not(:hover)::before {
            content: "";
            width: 100%;
            height: 100%;
            display: block;
            pointer-events: none;
            position: absolute;
            border-radius: 1rem;
            background: rgb(255,255,255);
            background: -moz-linear-gradient(120deg, rgba(255,255,255,0) 0%, rgba(255,196,56,0) 28%, rgba(255,179,0,1) 50%, rgba(255,187,25,0) 74%, rgba(255,255,255,0) 100%);
            background: -webkit-linear-gradient(120deg, rgba(255,255,255,0) 0%, rgba(255,196,56,0) 28%, rgba(255,179,0,1) 50%, rgba(255,187,25,0) 74%, rgba(255,255,255,0) 100%);
            background: linear-gradient(120deg, rgba(255,255,255,0) 0%, rgba(255,196,56,0) 28%, rgba(255,179,0,1) 50%, rgba(255,187,25,0) 74%, rgba(255,255,255,0) 100%);
            background-repeat: no-repeat;
            background-position-x: 100px;
            opacity: 0.3;
            border: 1px solid rgba(255,179,0);
            animation-name: gshine;
            animation-duration: 15s;
            animation-iteration-count: infinite;
        }

        .nav-item.shine {
            position: relative;
        }

        @keyframes gshine {
            from {
                background-position-x: -100px;
            }
            to {
                background-position-x: 200px;
            }
        }

        
        @media (display-mode: standalone) {
            [hidefrom="mobile"] {
                display: none;
            }
        }

        .card {
            margin-top: 10px;
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="/api/render/css?env=app&name=complex.scss" rel="stylesheet">

    <script src="/common/vendor/jquery/script.js"></script>
    <script src="/common/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="dark-mode not-shown ambient-lighting">
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand me-0 px-3 fs-6" href="#"><img width="120px" src="/mat/img/woosh.png" alt="PhysyRec Logo"></a>
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

            <li class="nav-item shine" hidefrom="mobile">
                <a class="nav-link active" aria-current="page" href="/complex.php/install" data-ajax="install">
                    <i class="fas fa-download"></i>
                    Install
                </a>
            </li>
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
    <script src="/common/vendor/duration-picker/out.js"></script>
</body>

</html>