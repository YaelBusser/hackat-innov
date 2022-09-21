<?php
namespace models;

use models\base\SQL;

class Organisateur extends SQL
{
    public function __construct()
    {
        parent::__construct('ORGANISATEUR', 'idorganisateur');
    }
}