<?php

namespace routes;

use controllers\EquipeApiController;
use controllers\HackathonApiController;
use controllers\MembreApiController;
use routes\base\Route;

class Api
{
    private HackathonApiController $hackathonApi;
    private EquipeApiController $equipeApi;
    private MembreApiController $membreApi;

    function __construct()
    {
        $this->hackathonApi = new HackathonApiController();
        $this->equipeApi = new EquipeApiController();
        $this->membreApi = new MembreApiController();

        // Route relative aux API Hackathon
        Route::Add('/api/hackathon/all', [$this->hackathonApi, 'getAll']);
        Route::Add('/api/hackathon/active', [$this->hackathonApi, 'getActiveHackathon']);
        Route::Add('/api/hackathon/{idh}/equipe', [$this->equipeApi, 'getEquipeByHackathon']);

        // Route relative aux API membre
        Route::Add('/api/membre/all', [$this->membreApi, 'getAll']);
        Route::Add('/api/membre/{idequipe}', [$this->membreApi, 'getByEquipeId']);

        // Route relative aux API équipe
        Route::Add('/api/equipe/all', [$this->equipeApi, 'getAll']);
        Route::Add('/api/equipe/create', [$this->equipeApi, 'create']);
        Route::Add('/api/equipe/auth', [$this->equipeApi, 'auth']);
        Route::Add('/api/equipe/{token}', [$this->equipeApi, 'getByToken']);
    }
}

