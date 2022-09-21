<?php

namespace models;

use Exception;
use models\base\SQL;
use utils\TokenHelpers;

class Token extends SQL
{
    public function __construct()
    {
        parent::__construct('TOKEN', 'uuid');
    }

    /**
     * Retourne une équipe à partir de son token.
     * @param String $token
     * @return mixed
     * @retur Equipe
     */
    public function getEquipeByToken(string $token): array
    {
        $stmt = $this->getPdo()->prepare("SELECT e.* FROM TOKEN LEFT JOIN equipe e on e.idequipe = TOKEN.idequipe WHERE uuid = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Génère un nouveau token pour l'équipe $idequipe.
     * @param String $idequipe
     * @return mixed|null
     * @throws Exception
     */
    public function add(string $idequipe): array|null
    {
        $token = TokenHelpers::guidv4();
        $stmt = $this->getPdo()->prepare("INSERT INTO TOKEN VALUES (?, ?)");
        $result = $stmt->execute([$token, $idequipe]);

        if ($result) {
            return $this->getOne($token);
        } else {
            return null;
        }
    }
}