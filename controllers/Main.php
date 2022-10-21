<?php

namespace controllers;

use controllers\base\WebController;
use models\Hackathon;
use models\Organisateur;
use utils\Template;

/**
 * Contrôleur principal
 */
class Main extends WebController
{
    private Hackathon $hackathon;
    private Organisateur $organisateur;

    public function __construct()
    {
        $this->hackathon = new Hackathon();
        $this->organisateur = new Organisateur();
    }

    function home(): string
    {
        $currentHackathon = $this->hackathon->getActive();
        $currentHackathonIsOpen = $this->hackathon->getHackathonIsOpen($currentHackathon['idhackathon']);
        $currentOrganisateur = $this->organisateur->getOne($currentHackathon['idorganisateur']);
        if (isset($_SESSION["LOGIN"]["idequipe"])) {
            $rejoindre = $this->hackathon->getInscrireByIdEquipe($_SESSION["LOGIN"]["idequipe"], $currentHackathon["idhackathon"]);
        }else{
            $rejoindre = false;
        }
        $currentDateNow = $this->hackathon->getDateNow();
        return Template::render("views/global/home.php", array("rejoindre" => $rejoindre, "hackathon" => $currentHackathon, "organisateur" => $currentOrganisateur, "hackathonIsOpen" => $currentHackathonIsOpen, "dateNow" => $currentDateNow));
    }

    function about(): string
    {
        return Template::render("views/global/about.php", array());
    }
}