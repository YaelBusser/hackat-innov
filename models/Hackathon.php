<?php

namespace models;

use models\base\SQL;

class Hackathon extends SQL
{
    public function __construct()
    {
        parent::__construct('HACKATHON', 'idhackathon');
    }

    /**
     * Retourne le Hackathon actuellement actif (en fonction de la date)
     * @return array|false
     */
    public function getActive(): bool|array
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM HACKATHON WHERE dateheurefinh > NOW() ORDER BY dateheuredebuth LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getHackathonForTeamId(string $idE)
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM HACKATHON LEFT JOIN INSCRIRE I on HACKATHON.idhackathon = I.idhackathon WHERE I.idequipe = ? AND dateheurefinh > NOW() ORDER BY dateheuredebuth LIMIT 1");
        $stmt->execute([$idE]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getHackathonIsOpen(int $idHackathon){
        $stmt = $this->getPdo()->prepare("SELECT MAX(nbEquipMax) AS nbEquipMax, COUNT(INSCRIRE.idequipe) AS nbEquip, INSCRIRE.dateinscription, dateFinInscription  FROM `HACKATHON` INNER JOIN INSCRIRE ON INSCRIRE.idhackathon = HACKATHON.idhackathon WHERE HACKATHON.idhackathon = ?;
");
        $stmt->execute([$idHackathon]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getDateNow(){
        $stmt = $this->getPdo()->prepare("SELECT DATE(NOW()) AS 'date'");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function joinHackathon(string $idH, string $idE): bool
    {
        $stmt = $this->getPdo()->prepare("INSERT INTO INSCRIRE VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE dateinscription = NOW()");
        return $stmt->execute([$idH, $idE]);
    }
}