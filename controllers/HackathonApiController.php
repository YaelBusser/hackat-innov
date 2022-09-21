<?php

namespace controllers;

use controllers\base\ApiController;
use models\Hackathon;
use utils\JsonHelpers;

class HackathonApiController extends ApiController
{
    private Hackathon $hackatons;

    function __construct()
    {
        $this->hackatons = new Hackathon();
    }

    /**
     * Retourne l'ensemble des Hackathons
     * @return string|false
     */
    function getAll(): string|bool
    {
        return JsonHelpers::stringify($this->hackatons->getAll());
    }

    /**
     * Retourn le Hackathon actuellement actif.
     * @return string|false
     */
    function getActiveHackathon(): string|bool
    {
        return JsonHelpers::stringify($this->hackatons->getActive());
    }
}