<?php

namespace models\base;

use PDO;

class SQL implements IDatabase
{
    protected $tableName = '';
    protected $primaryKey = '';

    /**
     * @var $pdo PDO
     */
    private static $pdo;

    /**
     * @return PDO
     */
    public static function getPdo(): PDO
    {
        if (SQL::$pdo == null) {
            SQL::$pdo = Database::connect();
        }

        return self::$pdo;
    }

    /**
     * @param String $tableName Nom de la table
     * @param String $primaryKey Clé primaire de la table
     */
    function __construct(string $tableName, string $primaryKey = 'id')
    {
        if (SQL::$pdo == null) {
            SQL::$pdo = Database::connect();
        }

        $this->tableName = $tableName;
        $this->primaryKey = $primaryKey;
    }

    /**
     * Retourne l'ensemble des enregistrements présent en base de données (pour la table $tableName)
     * @return array|null
     */
    public function getAll(): array|null
    {
        $stmt = SQL::$pdo->prepare("SELECT * FROM {$this->tableName};");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Permet la récupération d'un enregistrement en base de données
     * @param String $id
     * @return array|null
     */
    public function getOne(string $id): array|null
    {
        $stmt = SQL::$pdo->prepare("SELECT * FROM {$this->tableName} WHERE {$this->primaryKey} = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime l'enregistrement $id dans la table $tableName
     * @param $id
     * @return bool
     */
    public function deleteOne(string $id): bool
    {
        $stmt = SQL::$pdo->prepare("DELETE FROM {$this->tableName} WHERE {$this->primaryKey} = ? LIMIT 1");
        return $stmt->execute([$id]);
    }

    /**
     * Permet la mise à jour de l'ensemble des champs passée en paramètre dans $data pour l'enregistrement à $id.
     * @param $id
     * @param array $data
     * @return bool
     */
    public function updateOne(string $id, array $data = array()): bool
    {
        $query = "UPDATE {$this->tableName} SET ";

        foreach ($data as $columnName => $columnValue) {
            $query .= $columnName . " = :$columnName, ";
        }
        $query = rtrim($query, ", ");

        $query .= " WHERE {$this->primaryKey} = :id";

        $stmt = SQL::$pdo->prepare($query);
        return $stmt->execute(array_merge(["id" => $id], $data));
    }
}