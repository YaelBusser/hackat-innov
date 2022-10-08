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
    public function getByIdEquipe(string $idequipe): bool|array
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM EQUIPE e LEFT JOIN MEMBRE m on e.idequipe = m.idequipe WHERE m.idequipe = ?");
        $stmt->execute([$idequipe]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addToEquipe(string $nom, string $prenom, string $idE): bool
    {
        $stmt = $this->getPdo()->prepare("INSERT INTO MEMBRE(nom, prenom, idequipe, email) VALUES (?, ?, ?, '')");
        return $stmt->execute([$nom, $prenom, $idE]);
    }

    public function getAdminByLogin(string $nom)
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM ADMINISTRATEUR WHERE nom = ? LIMIT 1;
");
        $stmt->execute([$nom]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getByIdEquipeAndIdMembre(int $idEquipe, int $idMembre){
        $rqt = $this->getPdo()->prepare("SELECT * FROM EQUIPE e LEFT JOIN MEMBRE m on e.idequipe = m.idequipe WHERE m.idequipe = ? AND m.idmembre = ?");
        $rqt->execute([$idEquipe, $idMembre]);
        return $rqt->fetch(\PDO::FETCH_ASSOC);
    }
    public function deleteMembre(int $idEquipe, int $idMembre){
        $rqt = $this->getPdo()-> prepare("UPDATE MEMBRE SET idancienneequipe = idequipe, idequipe = null, date_supp_equipe = NOW() WHERE idequipe = ? AND idmembre = ?;");
        $rqt->execute([$idEquipe, $idMembre]);
    }
    public function getMembreSupp($idEquipe){
        $rqt = $this->getPdo()-> prepare("SELECT * FROM MEMBRE WHERE idancienneequipe = ? ORDER BY date_supp_equipe DESC;");
        $rqt->execute([$idEquipe]);
        return $rqt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function backMembreInEquipe(int $idMembre){
        $rqt = $this->getPdo()->prepare("UPDATE MEMBRE SET idequipe = 12, idancienneequipe = NULL, date_supp_equipe = NULL WHERE idmembre = ?");
        $rqt->execute([$idMembre]);
    }
    public function deleteFromEquipe(int $idMembre){
        $rqt = $this->getPdo()->prepare("DELETE FROM MEMBRE WHERE idmembre = ?");
        $rqt->execute([$idMembre]);
    }
}