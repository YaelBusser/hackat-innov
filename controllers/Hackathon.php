<?php

namespace controllers;

use controllers\base\WebController;
use utils\SessionHelpers;
class Hackathon extends WebController
{
    private \models\Hackathon $hackathon;

    public function __construct()
    {
        $this->hackathon = new \models\Hackathon();
        $this->equipe = new \models\Equipe();
    }
    /**
     * Méthode qui permet à une équipe de joindre un hackathon
     * @param String $idh
     * @return void
     */
    function join(string $idh = ""): void
    {
        $hackathonIsOpen = $this->hackathon->getHackathonIsOpen($idh);
        $dateNow = $this->hackathon->getDateNow();
        if (($hackathonIsOpen['nbEquip'] >= $hackathonIsOpen['nbEquipMax']) || ($dateNow['date'] >= $hackathonIsOpen['dateFinInscription'])) {
            $this->redirect("/");
        }
        // Si pas d'Id de passé en paramètre alors redirection en home
        if (!$idh) {
            $this->redirect("/");
        }

        // L'utilisateur est actuellement non connecté, redirection vers la page de login.
        if (!SessionHelpers::isLogin()) {
            $this->redirect("/login");
        }


        $this->hackathon->joinHackathon($idh, SessionHelpers::getConnected()['idequipe']);

        $this->redirect('/me');
    }
    function leaveHackathon(){
        $idEquipe = $_SESSION["LOGIN"]["idequipe"];
        $idHackthon = $_SESSION["hackathonActuel"]["idhackathon"];
        $this->equipe->leaveHackathon($idEquipe, $idHackthon);
        $this->redirect("/me");
    }
}