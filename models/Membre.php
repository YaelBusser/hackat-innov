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

    public function addToEquipe(int $idEquipe, string $nom, string $prenom, string $email, string $telephone, string $datenaissance, string $portfolio, string $avatar)
    {
        $stmt = $this->getPdo()->prepare("INSERT INTO MEMBRE(idequipe, nom, prenom, email, telephone, datenaissance, lienportfolio, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$idEquipe, $nom, $prenom, $email, $telephone, $datenaissance, $portfolio, $avatar]);
    }

    public function getAdminByLogin(string $nom)
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM ADMINISTRATEUR WHERE nom = ? LIMIT 1;
");
        $stmt->execute([$nom]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getByIdEquipeAndIdMembre(int $idEquipe, int $idMembre)
    {
        $rqt = $this->getPdo()->prepare("SELECT * FROM EQUIPE e LEFT JOIN MEMBRE m on e.idequipe = m.idequipe WHERE m.idequipe = ? AND m.idmembre = ?");
        $rqt->execute([$idEquipe, $idMembre]);
        return $rqt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteMembre(int $idEquipe, int $idMembre)
    {
        $rqt = $this->getPdo()->prepare("UPDATE MEMBRE SET idancienneequipe = idequipe, idequipe = null, date_supp_equipe = NOW() WHERE idequipe = ? AND idmembre = ?;");
        $rqt->execute([$idEquipe, $idMembre]);
    }

    public function getMembreSupp($idEquipe)
    {
        $rqt = $this->getPdo()->prepare("SELECT * FROM MEMBRE WHERE idancienneequipe = ? ORDER BY date_supp_equipe DESC;");
        $rqt->execute([$idEquipe]);
        return $rqt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function backMembreInEquipe(int $idequipe, int $idMembre)
    {
        $rqt = $this->getPdo()->prepare("UPDATE MEMBRE SET idequipe = ?, idancienneequipe = NULL, date_supp_equipe = NULL WHERE idmembre = ?");
        $rqt->execute([$idequipe, $idMembre]);
    }

    public function deleteFromEquipe(int $idMembre)
    {
        $rqt = $this->getPdo()->prepare("DELETE FROM MEMBRE WHERE idmembre = ? AND idancienneequipe = ? ");
        $rqt->execute([$idMembre, $_SESSION["LOGIN"]["idequipe"]]);
    }

    public function editMembre(string $nom, string $prenom, string $email, string $telephone, $dateNaissance, string $portfolio, int $idmembre)
    {
        $rqt = $this->getPdo()->prepare("UPDATE MEMBRE SET nom = ?, prenom = ?, email = ?, telephone = ?, datenaissance = ?, lienportfolio = ? WHERE idmembre = ?");
        $rqt->execute([$nom, $prenom, $email, $telephone, $dateNaissance, $portfolio, $idmembre]);
    }

    public function editMembreAvecAvatar(string $avatar, string $nom, string $prenom, string $email, string $telephone, $dateNaissance, string $portfolio, int $idmembre)
    {
        $rqt = $this->getPdo()->prepare("UPDATE MEMBRE SET nom = ?, prenom = ?, email = ?, telephone = ?, datenaissance = ?, lienportfolio = ?, avatar = ? WHERE idmembre = ?");
        $rqt->execute([$nom, $prenom, $email, $telephone, $dateNaissance, $portfolio, $avatar, $idmembre]);
    }

    public function getNbMembre(){
        $rqt = $this->getPdo()->prepare("SELECT COUNT(idmembre) AS 'nbMembre' FROM MEMBRE;");
        $rqt->execute();
        $fetch = $rqt->fetch();
        return $fetch;
    }
}