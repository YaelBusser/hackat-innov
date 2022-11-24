<?php

namespace controllers;

use controllers\base\WebController;
use models\Hackathon;
use models\Organisateur;
use models\Equipe;
use utils\Template;

/**
 * Contrôleur principal
 */
class Main extends WebController
{
    private Hackathon $hackathon;
    private Organisateur $organisateur;
    private Equipe $equipe;

    public function __construct()
    {
        $this->hackathon = new Hackathon();
        $this->organisateur = new Organisateur();
        $this->equipe = new Equipe();
    }

    function home(): string
    {
        $this->hackathon->nbVisites();
        $currentHackathon = $this->hackathon->getActive();
        $currentHackathonIsOpen = $this->hackathon->getHackathonIsOpen($currentHackathon['idhackathon']);
        $currentOrganisateur = $this->organisateur->getOne($currentHackathon['idorganisateur']);
        if (isset($_SESSION["LOGIN"]["idequipe"])) {
            $rejoindre = $this->hackathon->getInscrireByIdEquipe($_SESSION["LOGIN"]["idequipe"], $currentHackathon["idhackathon"]);
        } else {
            $rejoindre = false;
        }
        $currentDateNow = $this->hackathon->getDateNow();
        $nbEquipe = $this->hackathon->getNbEquipByIdHackathon($currentHackathon["idhackathon"]);
        return Template::render("views/global/home.php", array("nbEquipe" => $nbEquipe, "rejoindre" => $rejoindre, "hackathon" => $currentHackathon, "organisateur" => $currentOrganisateur, "hackathonIsOpen" => $currentHackathonIsOpen, "dateNow" => $currentDateNow));
    }

    function gcu(): string
    {
        $this->hackathon->nbVisites();
        return Template::render("views/global/gcu.php", array());
    }

    function about(): string
    {
        $currentHackathon = $this->hackathon->getActive();
        $organisateur = $this->hackathon->getOrganisateur();
        $this->hackathon->nbVisites();
        $hackathons = $this->hackathon->getAll();
        $nbEquipe = $this->hackathon->getNbEquipe();
        return Template::render("views/global/about.php", array("hackathons" => $hackathons, "organisateur" => $organisateur, "nbEquipe" => $nbEquipe));
    }

    function statspublic()
    {
        $this->hackathon->nbVisites();
        $visites = $this->hackathon->getNbVisites();
        $avgAge = $this->hackathon->getAvgAgeByHackathon();
        $nbEquipeTotal = $this->equipe->getNbEquipe();
        return Template::render("views/global/stats.php", array("visites" => $visites, "avgAge" => $avgAge, "nbEquipe" => $nbEquipeTotal));
    }
}