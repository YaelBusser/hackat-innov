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

    public function getInscrireByIdEquipe($idE, $idhackathon)
    {
        $rqt = $this->getPdo()->prepare("SELECT idhackathon, idequipe FROM INSCRIRE WHERE idequipe = ? AND idhackathon = ?");
        $rqt->execute([$idE, $idhackathon]);
        return $rqt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getHackathonIsOpen($idHackathon)
    {
        $stmt = $this->getPdo()->prepare("SELECT MAX(nbEquipMax) AS nbEquipMax, COUNT(INSCRIRE.idequipe) AS nbEquip, INSCRIRE.dateinscription, dateFinInscription  FROM `HACKATHON` INNER JOIN INSCRIRE ON INSCRIRE.idhackathon = HACKATHON.idhackathon WHERE HACKATHON.idhackathon = ?;
");
        $stmt->execute([$idHackathon]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getDateNow()
    {
        $stmt = $this->getPdo()->prepare("SELECT DATE(NOW()) AS 'date'");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function joinHackathon(string $idH, string $idE): bool
    {
        $stmt = $this->getPdo()->prepare("INSERT INTO INSCRIRE VALUES (?, ?, NOW(), NULL)");
        return $stmt->execute([$idH, $idE]);
    }

    public function getInscrire(int $idHackathon)
    {
        $rqt = $this->getPdo()->prepare("SELECT COUNT(INSCRIRE.idequipe) AS 'nbequipe', dateinscription FROM INSCRIRE INNER JOIN EQUIPE ON EQUIPE.idequipe = INSCRIRE.idequipe WHERE idhackathon = ? GROUP BY dateinscription;");
        $rqt->execute([$idHackathon]);
        $fetch = $rqt->fetchAll();
        return $fetch;
    }

    public function getNbEquipByIdHackathon(int $idHackathon)
    {
        $rqt = $this->getPdo()->prepare("SELECT COUNT(INSCRIRE.idequipe) AS 'nbequipe' FROM INSCRIRE INNER JOIN EQUIPE ON EQUIPE.idequipe = INSCRIRE.idequipe WHERE idhackathon = ?;");
        $rqt->execute([$idHackathon]);
        $fetch = $rqt->fetch();
        return $fetch;
    }

    public function getNbEquipe(){
        $rqt = $this->getPdo()->prepare("SELECT COUNT(idequipe) AS 'nbequipe', idhackathon FROM INSCRIRE GROUP BY idhackathon;");
        $rqt->execute();
        $fetch = $rqt->fetchAll();
        return $fetch;
    }

    public function nbVisites()
    {
        // On prépare les données à insérer
        $ip = $_SERVER['REMOTE_ADDR']; // L'adresse IP du visiteur
        $date = date('Y-m-d');           // La date d'aujourd'hui, sous la forme AAAA-MM-JJ
        // Mise à jour de la base de données
        // 1. On initialise la requête préparée
        $query = $this->getPdo()->prepare("INSERT INTO stats_visites (ip , date_visite , pages_vues) VALUES (:ip , :date , 1) ON DUPLICATE KEY UPDATE pages_vues = pages_vues + 1");
        // 2. On execute la requête préparée avec nos paramètres
        $query->execute(array(
            ':ip' => $ip,
            ':date' => $date
        ));
    }

    public function getOrganisateur()
    {
        $rqt = $this->getPdo()->prepare("SELECT HACKATHON.idhackathon, ORGANISATEUR.nom, ORGANISATEUR.prenom, ORGANISATEUR.idorganisateur FROM HACKATHON INNER JOIN ORGANISATEUR ON HACKATHON.idorganisateur = ORGANISATEUR.idorganisateur;");
        $rqt->execute();
        $fetch = $rqt->fetchAll();
        return $fetch;
    }

    public function getNbVisites()
    {
        $rqt = $this->getPdo()->prepare("SELECT SUM(pages_vues) AS 'vues', date_visite AS 'date' FROM stats_visites GROUP BY date_visite;");
        $rqt->execute();
        $fetch = $rqt->fetchAll();
        return $fetch;
    }

    public function getAvgAgeByHackathon()
    {
        $rqt = $this->getPdo()->prepare("SELECT ROUND(AVG(DATEDIFF(NOW(), datenaissance))/365.25) AS 'age', INSCRIRE.idhackathon, HACKATHON.thematique AS 'thematique' FROM `MEMBRE` INNER JOIN INSCRIRE ON INSCRIRE.idequipe = MEMBRE.idequipe INNER JOIN HACKATHON ON HACKATHON.idhackathon = INSCRIRE.idhackathon GROUP BY INSCRIRE.idhackathon;");
        $rqt->execute();
        $fetch = $rqt->fetchAll();
        return $fetch;
    }
}