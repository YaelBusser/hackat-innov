<?php

namespace routes;

use views\global\home;
use controllers\Equipe;
use controllers\Hackathon;
use controllers\Main;
use controllers\ApiDoc;
use routes\base\Route;
use utils\SessionHelpers;


class Web
{
    private ApiDoc $apiDoc;
    private Main $main;
    private Equipe $equipe;
    private Hackathon $hackathon;

    function __construct()
    {
        $this->main = new Main();
        $this->hackathon = new Hackathon();
        $this->equipe = new Equipe();
        $this->apiDoc = new ApiDoc();

        Route::Add('/', [$this->main, 'home']);
        Route::Add('/about', [$this->main, 'about']);
        Route::Add('/login', [$this->equipe, 'login']);
        if (!$_SESSION["errorHackathonIsOpen"]) {
            Route::Add('/join', [$this->hackathon, 'join']);
            Route::Add('/create-team', [$this->equipe, 'create']);
        }
        // Liste des routes de la partie API
        Route::Add('/sample/', [$this->apiDoc, 'liste']);
        Route::Add('/sample/hackathons', [$this->apiDoc, 'listeHackathons']);
        Route::Add('/sample/ateliers', [$this->apiDoc, 'listeAteliers']);
        Route::Add('/sample/membres', [$this->apiDoc, 'listeMembres']);
        Route::Add('/sample/equipes', [$this->apiDoc, 'listeEquipes']);

        if (SessionHelpers::isLogin()) {
            // Ici seront les routes nécessitant un accès protégés
            Route::Add('/logout', [$this->equipe, 'logout']);
            Route::Add('/me', [$this->equipe, 'me']);
            Route::Add('/membre/add', [$this->equipe, 'addMembre']);
        }
    }
}

