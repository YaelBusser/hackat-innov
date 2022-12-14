<?php

namespace routes;

use controllers\ApiDoc;
use controllers\Equipe;
use controllers\Hackathon;
use controllers\Main;
use routes\base\Route;
use utils\SessionHelpers;
use views\global\home;


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
        Route::Add('/gcu', [$this->main, 'gcu']);
        Route::Add('/about', [$this->main, 'about']);
        Route::Add('/aboutHackathon/{idhackathon}', [$this->main, 'aboutHackathon']);
        Route::Add('/statspublic', [$this->main, 'statspublic']);
        Route::Add('/login', [$this->equipe, 'login']);
        Route::Add('/create-team', [$this->equipe, 'create']);
        // Liste des routes de la partie API


        if (isset($_SESSION["admin"])) {
            Route::Add('/sample/', [$this->apiDoc, 'liste']);
            Route::Add('/sample/hackathons', [$this->apiDoc, 'listeHackathons']);
            Route::Add('/sample/hackathon/stats/{idhackathon}', [$this->apiDoc, 'statHackathon']);
            Route::Add('/sample/ateliers', [$this->apiDoc, 'listeAteliers']);
            Route::Add('/sample/membres', [$this->apiDoc, 'listeMembres']);
            Route::Add('/sample/equipes', [$this->apiDoc, 'listeEquipes']);
            Route::Add("/deconnectionAdmin", [$this->apiDoc, "logOutApi"]);
        } else {
            Route::Add('/connexionApi', [$this->apiDoc, 'connexionApi']);
        }

        if (SessionHelpers::isLogin()) {
            // Ici seront les routes nécessitant un accès protégés
            Route::Add('/logout', [$this->equipe, 'logout']);

            Route::Add('/me', [$this->equipe, 'me']);
            Route::Add("/editEquipe", [$this->equipe, "editEquipe"]);

            Route::Add('/membre/add', [$this->equipe, 'addMembre']);
            Route::Add('/membre/{id}', [$this->equipe, 'getMembre']);
            Route::Add('/editMembre/{id}', [$this->equipe, 'editMembre']);
            Route::Add('/deleteMembre/{id}', [$this->equipe, 'meDelete']);
            Route::Add("/deleteLeMembre/{id}", [$this->equipe, "meDeleteLeMembre"]);
            Route::Add("/membreSupp/", [$this->equipe, "getMembreSupp"]);
            Route::Add("/backToEquipe/{idMembre}", [$this->equipe, "backMembreInEquipe"]);
            Route::Add("/deleteFromEquipe/{idMembre}", [$this->equipe, "deleteFromEquipe"]);
            Route::Add("/addMembre", [$this->equipe, "addMembre"]);
            Route::Add("/errorEditMembre", [$this->equipe, ""]);

            Route::Add('/join', [$this->hackathon, 'join']);
            Route::Add('/leaveHackathon', [$this->hackathon, 'leaveHackathon']);
        }
    }
}

