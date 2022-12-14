<?php

use routes\base\Route;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackat'innov</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
          rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link href="/public/main.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="/public/img/logo.png">

    <!-- La balise style présente ici permet d'éviter au plus tôt le « flash » de contenu lié à VueJS -->
    <style>
        [v-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>

<div class="sticky-top header">
    <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills w-100 d-flex">
            <li class="nav-item"><a href="/" class="nav-link white-link <?= Route::isActivePath('/', 'active-link') ?>"
                                    aria-current="page">Home</a></li>
            <li class="nav-item"><a href="/about"
                                    class="nav-link white-link <?= Route::isActivePath('/about', 'active-link') ?>"">About</a>
            </li>
            <li class="nav-item"><a href="/gcu"
                                    class="nav-link white-link <?= Route::isActivePath('/gcu', 'active-link') ?>"">GCU</a>
            </li>
            <li class="nav-item"><a href="/statspublic"
                                    class="nav-link white-link <?= Route::isActivePath('/statspublic', 'active-link') ?>"">Statistiques</a>
            </li>
            <li class="flex-grow-1"></li>

            <?php if (!\utils\SessionHelpers::isLogin()) { ?>
                <li class="nav-item"><a href="/login"
                                        class="nav-link white-link <?= Route::isActivePath('/login', 'active-link') ?>"">Login</a>
                </li>
            <?php } else { ?>
                <li class="nav-item"><a href="/me"
                                        class="nav-link white-link <?= Route::isActivePath('/me', 'active-link') ?>">Mon
                        profil</a></li>
            <?php } ?>
            <?php if (isset($_SESSION["admin"])) { ?>
                <li class="nav-item"><a href="/sample/"
                                        class="nav-link white-link <?= Route::isActivePath('/connexionApi', 'active-link') ?>"">🔐
                    API</a></li>
                <li class="nav-item"><a href="/deconnectionAdmin"
                                        class="nav-link white-link"><i class="bi bi-box-arrow-in-right"></i>

                    </a></li>
            <?php } else { ?>
                <li class="nav-item"><a href="/connexionApi"
                                        class="nav-link white-link <?= Route::isActivePath('/connexionApi', 'active-link') ?>"">🔐
                    API</a></li>
            <?php } ?>
        </ul>
    </header>
</div>

