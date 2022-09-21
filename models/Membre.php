<?php

namespace models;

use models\base\SQL;

class Membre extends SQL
{
    public function __construct()
    {
        parent::__construct('MEMBRE', 'idmembre');
    }

    /**
     * Retourne les membres d'une équipe $idequipe
     * @param string $idequipe
     * @return bool|array
     */
    public function getByIdEquipe(String $idequipe): bool|array
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM EQUIPE e LEFT JOIN MEMBRE m on e.idequipe = m.idequipe WHERE m.idequipe = ?");
        $stmt->execute([$idequipe]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addToEquipe(String $nom, String $prenom, String $idE): bool
    {
        $stmt = $this->getPdo()->prepare("INSERT INTO MEMBRE(nom, prenom, idequipe, email) VALUES (?, ?, ?, '')");
        return $stmt->execute([$nom, $prenom, $idE]);
    }
}