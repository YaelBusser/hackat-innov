<?php

namespace controllers;

use controllers\base\WebController;
use http\Header;
use models\Membre;
use models\Hackathon;
use utils\SessionHelpers;
use utils\Template;

class Equipe extends WebController
{
    private Hackathon $hackathon;
    private Membre $membre;
    private \models\Equipe $equipe;

    public function __construct()
    {
        $this->hackathon = new Hackathon();
        $this->membre = new Membre();
        $this->equipe = new \models\Equipe();
    }

    /**
     * Affichage du profil d'une équipe
     * @return string
     */
    function me(): string
    {
        $connected = SessionHelpers::getConnected();
        $relatedHackathon = $this->hackathon->getHackathonForTeamId($connected['idequipe']);
        $membres = $this->membre->getByIdEquipe($connected['idequipe']);

        return Template::render("views/equipe/me.php", array('hackathon' => $relatedHackathon, 'connected' => $connected, "membres" => $membres));
    }

    function meEdit($id)
    {
        $connected = SessionHelpers::getConnected();
        $membres = $this->membre->getByIdEquipeAndIdMembre($connected['idequipe'], $id);
        return Template::render("views/equipe/editMembre.php", array("membres" => $membres), false);
    }

    function meDelete($id)
    {
        $connected = SessionHelpers::getConnected();
        $membres = $this->membre->getByIdEquipeAndIdMembre($connected['idequipe'], $id);
        return Template::render("views/equipe/deleteMembre.php", array("membres" => $membres), false);
    }

    function meDeleteLeMembre($id)
    {
        $connected = SessionHelpers::getConnected();
        $this->membre->deleteMembre($connected['idequipe'], $id);
        $this->redirect("/me");
    }

    function getMembreSupp()
    {
        $connected = SessionHelpers::getConnected();
        $membresSupp = $this->membre->getMembreSupp($connected["idequipe"]);
        return Template::render("views/equipe/membreSupp.php", array("membresSupp" => $membresSupp), false);
    }

    function backMembreInEquipe($idMembre)
    {
        $this->membre->backMembreInEquipe($idMembre);
        $this->redirect("/me");
    }

    function deleteFromEquipe($idMembre)
    {
        $this->membre->deleteFromEquipe($idMembre);
        $this->redirect("/me");
    }

    /**
     * Méthode d'ajout d'un membre. Appelé depuis la vue de profil
     * @param $nom
     * @param $prenom
     * @return void
     */
    function addMembre($nom = "", $prenom = ""): void
    {
        if (!empty($nom) && !empty($prenom)) {
            $connected = SessionHelpers::getConnected();
            $this->membre->addToEquipe($nom, $prenom, $connected['idequipe']);
        }

        $this->redirect('/me');
    }

    /**
     * Méthode de création d'une nouvelel équipe en base. Une équipe est forcément rattachée à un hackathon
     * @param $idh
     * @param $nom
     * @param $lien
     * @param $login
     * @param $password
     * @return string
     */
    function create($idh = "", $nom = "", $lien = "", $login = "", $password = ""): string
    {
        // Si pas d'Id de passé en paramètre alors redirection en home
        if (!$idh) {
            $this->redirect("/");
        }
        $hackathonIsOpen = $this->hackathon->getHackathonIsOpen($idh);
        $dateNow = $this->hackathon->getDateNow();
        if (($hackathonIsOpen['nbEquip'] >= $hackathonIsOpen['nbEquipMax']) || ($dateNow['date'] >= $hackathonIsOpen['dateFinInscription'])) {
            $this->redirect("/");
        }
        $erreur = "";
        if (!empty($idh) && !empty($nom) && !empty($lien) && !empty($login) && !empty($password)) {
            // Création de l'équipe
            $equipe = $this->equipe->create($nom, $lien, $login, $password);

            if ($equipe != null) {
                // Ajout de l'équipe dans le hackathon demandé
                $this->hackathon->joinHackathon($idh, $equipe['idequipe']);
                SessionHelpers::login($equipe);
                $this->redirect('/me');
            } else {
                $erreur = "Création de votre équipe impossible";
            }

        }
        return Template::render("views/equipe/create.php", array("idh" => $idh, "erreur" => $erreur));
    }

    /**
     * Méthode de connexion d'une équipe
     * @param $login
     * @param $password
     * @return string
     */
    function login($login = "", $password = ""): string
    {
        if (SessionHelpers::isLogin()) {
            $this->redirect("/");
        }

        $erreur = "";
        if (!empty($login) && !empty($password)) {
            $equipeController = new \models\Equipe();

            $lequipe = $equipeController->login($login, $password);
            if ($lequipe != null) {
                SessionHelpers::login($lequipe);
                $this->redirect("/me");
            } else {
                SessionHelpers::logout();
                $erreur = "Connexion impossible avec vos identifiants";
            }
        }

        return Template::render("views/equipe/login.php", array("erreur" => $erreur));
    }

    /**
     * Déconnexion de la plateforme
     * @return void
     */
    function logout(): void
    {
        SessionHelpers::logout();
        $this->redirect("/");
    }
}