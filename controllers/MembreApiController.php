<?php

namespace controllers;

use controllers\base\ApiController;
use models\Membre;
use utils\JsonHelpers;

class MembreApiController extends ApiController
{
    private Membre $membres;

    function __construct()
    {
        $this->membres = new Membre();
    }

    /**
     * Retourne l'ensemble des membres présents en base de données
     * @return void
     */
    function getAll(): String
    {
        return JsonHelpers::stringify($this->membres->getAll());
    }

    /**
     * Retourne les membres d'une équipe précise
     * @param String $idequipe
     * @return void
     */
    function getByEquipeId(String $idequipe = ""): String
    {
        return JsonHelpers::stringify($this->membres->getByIdEquipe($idequipe));
    }
}