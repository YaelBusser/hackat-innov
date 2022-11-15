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
        $_SESSION["hackathonActuel"] = $relatedHackathon;
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
        $_SESSION["errorBackMember"] = "";
        $nbMembres = $this->equipe->getNbMembres($_SESSION["LOGIN"]["idequipe"]);
        if ($nbMembres["membres"] < $_SESSION["LOGIN"]["nbparticipants"]) {
            $this->membre->backMembreInEquipe($idMembre);
        }else{
            $_SESSION["errorBackMember"] = "Vous ne pouvez pas récupérer ce membre car le nombre maximum de membres a été atteint !";
        }
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
    function addMembre($nom, $prenom, $email, $tel, $dateNaissance, $portfolio)
    {
        $errorAddMembre = "";
        if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($tel) && !empty($dateNaissance)) {
            $nom = htmlspecialchars($nom);
            $prenom = htmlspecialchars($prenom);
            $email = htmlspecialchars($email);
            $tel = htmlspecialchars($tel);
            $dateNaissance = htmlspecialchars($dateNaissance);
            $connected = SessionHelpers::getConnected();
            $nbMembres = $this->equipe->getNbMembres($_SESSION["LOGIN"]["idequipe"]);
            if ($nbMembres["membres"] < $_SESSION["LOGIN"]["nbparticipants"]) {
                if (!empty($portfolio)) {
                    $portfolio = htmlspecialchars($portfolio);
                    $this->membre->addToEquipe($connected['idequipe'], $nom, $prenom, $email, $tel, $dateNaissance, $portfolio);
                } else {
                    $this->membre->addToEquipe($connected['idequipe'], $nom, $prenom, $email, $tel, $dateNaissance, "");
                }
            } else {
                $errorAddMembre = "Le nombre maximum de membres a été atteint !";
            }
        }else{
            $errorAddMembre = "Veuillez remplir tous les champs !";
        }
        //$this->redirect('/me');
        return Template::render("views/equipe/addMembre.php", array("error" => $errorAddMembre), false);
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

    function editEquipe($nom = "", $login = "", $proto = "", $participants = "", $mdpActuel = "", $mdp = "", $mdp2 = "",)
    {
        $errorEditEquipe = "";
        if (isset($nom)) {
            $nom = htmlspecialchars($nom);
            $login = htmlspecialchars($login);
            $proto = htmlspecialchars($proto);
            $participants = htmlspecialchars($participants);
            $participants = intval($participants);
            if (!empty($nom) && !empty($login) && !empty($proto) && !empty($participants)) {
                $verifyTeamName = $this->equipe->verifyTeamName($nom);
                $nbVerifyTeamName = $verifyTeamName->rowCount();
                if ($nbVerifyTeamName == 0 || $nom == $_SESSION["LOGIN"]["nomequipe"]) {
                    $verifyLogin = $this->equipe->verifyLogin($login);
                    $nbverifyLogin = $verifyLogin->rowCount();
                    if ($nbverifyLogin == 0 || $login == $_SESSION["LOGIN"]["login"]) {
                        $nbMembres = $this->equipe->getNbMembres($_SESSION["LOGIN"]["idequipe"]);
                        if ($nbMembres["membres"] <= $participants) {
                            $_SESSION["LOGIN"]["nomequipe"] = $nom;
                            $_SESSION["LOGIN"]["lienprototype"] = $proto;
                            $_SESSION["LOGIN"]["nbparticipants"] = $participants;
                            $_SESSION["LOGIN"]["login"] = $login;
                            $this->equipe->modifEquipeSansMdp($nom, $login, $proto, $participants, $_SESSION["LOGIN"]["idequipe"]);
                            if (!empty($mdpActuel)) {
                                if (password_verify($mdpActuel, $_SESSION["LOGIN"]["password"])) {
                                    if (!empty($mdp) && !empty($mdp2)) {
                                        if ($mdp == $mdp2) {
                                            $mdp = password_hash($mdp, PASSWORD_BCRYPT);
                                            $this->equipe->modifEquipe($nom, $login, $proto, $participants, $mdp, $_SESSION["LOGIN"]["idequipe"]);
                                            $_SESSION["LOGIN"]["password"] = $mdp;
                                        } else {
                                            $errorEditEquipe = "Les mots de passes doivent être identiques !";
                                        }
                                    }
                                } else {
                                    $errorEditEquipe = "Le mot de passe actuel est incorrecte !";
                                }
                            }
                        } else {
                            $errorEditEquipe = "Le nombre maximum de participants est inférieur à votre nombre de membres !";
                        }
                    } else {
                        $errorEditEquipe = "Le login existe déjà !";
                    }
                } else {
                    $errorEditEquipe = "Le nom de team existe déjà !";
                }
                if (empty($mdpActuel) && !empty($mdp) && !empty($mdp2)) {
                    $errorEditEquipe = "Vous devez d'abord renseigner votre mot de passe actuel !";
                }
            } else {
                $errorEditEquipe = "Les champs ne doivent pas être vides !";
            }
        }
        return Template::render("views/equipe/editEquipe.php", array("error" => $errorEditEquipe), false);
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