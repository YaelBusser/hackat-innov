<?php

namespace controllers;

use controllers\base\WebController;
use models\Equipe;
use models\Hackathon;
use models\Membre;
use utils\Template;

/**
 * Ensemble de méthode en lien avec l'API.
 */

class ApiDoc extends WebController
{
    private Equipe $equipes;
    private Hackathon $hackatons;
    private Membre $membres;

    function __construct()
    {
        $this->equipes = new Equipe();
        $this->membres = new Membre();
        $this->hackatons = new Hackathon();
    }

    function liste(): string
    {
        return Template::render("views/apidoc/liste.php");
    }

    function listeHackathons(): string
    {
        return Template::render("views/apidoc/hackathon.php", array('data' => $this->hackatons->getAll()));
    }

    function listeMembres(String $idequipe = ""): string
    {
        $lequipe = null;
        if ($idequipe != "") {
            // Récupération de l'équipe passé en paramètre
            $lequipe = $this->equipes->getOne($idequipe);
            $data = $this->membres->getByIdEquipe($idequipe);
        } else {
            $data = $this->membres->getAll();
        }

        return Template::render("views/apidoc/membre.php", array('data' => $data, 'lequipe' => $lequipe));
    }

    function listeEquipes(String $idh = ""): string
    {
        $hackathon = null;
        if ($idh != "") {
            // Récupération de l'équipe passé en paramètre
            $hackathon = $this->hackatons->getOne($idh);
            $data = $this->equipes->getForIdHackathon($idh);
        } else {
            $data = $this->equipes->getAll();
        }

        return Template::render("views/apidoc/equipe.php", array('data' => $data, 'hackathon' => $hackathon));
    }
}
