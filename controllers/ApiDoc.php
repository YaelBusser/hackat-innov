<?php

namespace controllers;

use controllers\base\WebController;
use models\Equipe;
use models\Hackathon;
use models\Membre;
use utils\SessionHelpers;
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

    function connexionApi(): string
    {
        $errorApi = "";
        if (isset($_POST["btnAdmin"])) {
            if (!empty(["login"]) && !empty($_POST["password"])) {
                $login = htmlspecialchars($_POST["login"]);
                $pwd = $_POST["password"];
                $connection = $this->membres->getAdminByLogin($login);
                if (password_verify($pwd, $connection["motpasse"])) {
                    $_SESSION["admin"] = $connection;
                    #echo $_SESSION["admin"]["nom"]; Cela permet de récupérer toutes les infos des users.

                    $this->redirect("/sample/");
                } else {
                    $errorApi = "Le mot de passe est incorrecte !";
                }

            } else {
                $errorApi = "Veuillez remplir tous les champs !";
            }
        }
        return Template::render("views/apidoc/connexionApi.php", array("errorApi" => $errorApi));
    }

    function logOutApi()
    {
        SessionHelpers::logOutApi();
        $this->redirect("/connexionApi");
    }

    function liste(): string
    {
        return Template::render("views/apidoc/liste.php");
    }

    function listeHackathons(): string
    {
        return Template::render("views/apidoc/hackathon.php", array('data' => $this->hackatons->getAll()));
    }

    function listeMembres(string $idequipe = ""): string
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

    function listeEquipes(string $idh = ""): string
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
    function statHackathon(int $idhackathon){
        $inscrire = $this->hackatons->getInscrire($idhackathon);
        return Template::render("views/apidoc/statHackathon.php", array("hackathon" => $this->hackatons->getOne($idhackathon), "inscrire" => $inscrire));
    }
}
