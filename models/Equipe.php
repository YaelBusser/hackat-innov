<?php

namespace models;

use Exception;
use models\base\SQL;

class Equipe extends SQL
{
    public function __construct()
    {
        parent::__construct('EQUIPE', 'idequipe');
    }

    /**
     * Retourne les équipes ainsi que leur nombre de participations à un événement.
     * @return bool|array
     */
    function getAllWithParticipationCount(): bool|array
    {
        $stmt = $this->getPdo()->prepare("SELECT e.* FROM EQUIPE e LEFT JOIN INSCRIRE i on e.idequipe = i.idequipe");
        $stmt->execute([]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Créer un une équipe en base de données.
     * @param string $nomequipe
     * @param string $lienprototype
     * @param string $nbparticipants
     * @param string $login
     * @param string $password
     * @return mixed|null
     */
    public function add(string $nomequipe, string $lienprototype, string $nbparticipants, string $login, string $password): array|null
    {
        try {
            $stmt = $this->getPdo()->prepare("INSERT INTO EQUIPE VALUES(null, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$nomequipe, $lienprototype, $nbparticipants, $login, password_hash($password, PASSWORD_BCRYPT)]);
            if ($result) {
                return self::getOne($this->getPdo()->lastInsertId());
            } else {
                return null;
            }
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * Authentifie une équipe en fonction de son login et mot de passe.
     * @param string $login
     * @param string $password
     * @return mixed|null
     */
    public function auth(string $login, string $password): array|null
    {
        $stmt = $this->getPdo()->prepare('SELECT * FROM EQUIPE WHERE login = ? LIMIT 1');
        $stmt->execute([$login]);
        $equipe = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (password_verify($password, $equipe['password'])) {
            $token = new Token();
            return $token->add($equipe['idequipe']);
        } else {
            return null;
        }

    }

    public function login(string $login, string $password): array|null
    {
        $stmt = $this->getPdo()->prepare('SELECT * FROM EQUIPE WHERE login = ? LIMIT 1');
        $stmt->execute([$login]);
        $equipe = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($equipe) {
            if (password_verify($password, $equipe['password'])) {
                return $equipe;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Retourne les équipes pour un hackathon précis.
     * @param $idh
     * @return bool|array
     */
    public
    function getForIdHackathon($idh): bool|array
    {
        $stmt = $this->getPdo()->prepare('SELECT * FROM EQUIPE e LEFT JOIN INSCRIRE i on e.idequipe = i.idequipe WHERE i.idhackathon = ?');
        $stmt->execute([$idh]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(mixed $nom, mixed $lien, mixed $login, mixed $password, bool $estArchive): array|null
    {
        try {
            $stmt = $this->getPdo()->prepare("INSERT INTO EQUIPE VALUES(null, ?, ?, 0, ?, ?, ?)");
            $result = $stmt->execute([$nom, $lien, $login, password_hash($password, PASSWORD_BCRYPT), 0]);

            if ($result) {
                return $this->getOne($this->getPdo()->lastInsertId());
            } else {
                return null;
            }
        } catch (Exception $exception) {
            return null;
        }
    }

    public function modifEquipe(string $nomEquipe, string $login, string $lienPrototype, int $nbParticipants, string $password, int $idEquipe)
    {
        $rqt = $this->getPdo()->prepare("UPDATE EQUIPE SET nomequipe = ?, login = ?, lienprototype = ?, nbparticipants = ?, password = ? WHERE idequipe = ?");
        $rqt->execute([$nomEquipe, $login, $lienPrototype, $nbParticipants, $password, $idEquipe]);
    }

    public function modifEquipeSansMdp(string $nomEquipe, string $login, string $lienPrototype, int $nbParticipants, int $idEquipe)
    {
        $rqt = $this->getPdo()->prepare("UPDATE EQUIPE SET nomequipe = ?, login = ?, lienprototype = ?, nbparticipants = ? WHERE idequipe = ?");
        $rqt->execute([$nomEquipe, $login, $lienPrototype, $nbParticipants, $idEquipe]);
    }

    public function leaveHackathon(int $idEquipe, int $idHackathon)
    {
        $rqt = $this->getPdo()->prepare("DELETE FROM INSCRIRE WHERE idequipe = ? AND idhackathon = ?");
        $rqt->execute([$idEquipe, $idHackathon]);
    }

    public function verifyTeamName(string $nomEquipe)
    {
        $rqt = $this->getPdo()->prepare("SELECT nomequipe FROM EQUIPE WHERE nomequipe = ?");
        $rqt->execute([$nomEquipe]);
        return $rqt;
    }

    public function verifyLogin(string $login)
    {
        $rqt = $this->getPdo()->prepare("SELECT login FROM EQUIPE WHERE login = ?");
        $rqt->execute([$login]);
        return $rqt;
    }

    public function getNbMembres(int $idEquipe)
    {
        $rqt = $this->getPdo()->prepare("SELECT COUNT(idmembre) AS 'membres' FROM MEMBRE INNER JOIN EQUIPE ON EQUIPE.idequipe = MEMBRE.idequipe WHERE EQUIPE.idequipe = ?;");
        $rqt->execute([$idEquipe]);
        $fetch = $rqt->fetch();
        return $fetch;
    }

    public function getNbMembresMax(int $idEquipe)
    {
        $rqt = $this->getPdo()->prepare("SELECT nbparticipants AS 'membres' FROM EQUIPE WHERE idequipe = ?;");
        $rqt->execute([$idEquipe]);
        $fetch = $rqt->fetch();
        return $fetch;
    }
}
