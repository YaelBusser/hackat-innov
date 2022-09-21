<?php

namespace controllers;

use controllers\base\ApiController;
use models\Equipe;
use models\Token;
use utils\JsonHelpers;

class EquipeApiController extends ApiController
{
    private Equipe $equipes;
    private Token $token;

    function __construct()
    {
        $this->equipes = new Equipe();
        $this->token = new Token();
    }

    /**
     * Retourne l'ensemble des équipes présentes en base de données.
     * @return string|false
     */
    function getAll(): string|bool
    {
        return JsonHelpers::stringify($this->equipes->getAll());
    }

    /**
     * Retourne l'ensemble des équipe pour un Hackathon précis.
     * @param String $idh
     * @return string|false
     */
    function getEquipeByHackathon(String $idh): string|bool
    {
        return JsonHelpers::stringify($this->equipes->getForIdHackathon($idh));
    }

    /**
     * Génère un token permettant de retrouver une équipe en base de données.
     * Ce token est utilisé pour authentifié une équipe dans l'application cliente.
     * @param String $login
     * @param String $password
     * @return string|false
     */
    function auth(String $login = '', String $password = ''): string|bool
    {
        if (isset($login, $password)) {
            $token = $this->equipes->auth($login, $password);
            return JsonHelpers::stringify(["success" => 1, "result" => $token]);
        } else {
            return JsonHelpers::stringify(["success" => 0, "result" => null]);
        }
    }

    /**
     * Retourne une équipe en fonction du token passé en paramètres.
     * @param string $token
     * @return string|false
     */
    function getByToken(string $token = ""): string|bool
    {
        return JsonHelpers::stringify($this->token->getEquipeByToken($token));
    }

    /**
     * Création d'une nouvelle équipe.
     * Cette action est exposée via une API
     * Nécéssite la fourniture des paramètres :
     * - nomequipe
     * - lienprototype
     * - nbparticipants
     * - login
     * - password
     * @return string|false
     */
    function create(): string|bool
    {
        if (isset($_POST['nomequipe'], $_POST['lienprototype'], $_POST['nbparticipants'], $_POST['login'], $_POST['password'])) {
            $result = $this->equipes->add($_POST['nomequipe'], $_POST['lienprototype'], $_POST['nbparticipants'], $_POST['login'], $_POST['password']);

            if ($result) {
                return JsonHelpers::stringify(["success" => 1, "result" => $result]);
            } else {
                return JsonHelpers::stringify(["success" => 0, "result" => null]);
            }
        } else {
            return JsonHelpers::stringify(["success" => 0, "result" => null]);
        }
    }
}