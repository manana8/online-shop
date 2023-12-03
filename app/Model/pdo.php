<?php

class ConnectionDB {
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}

