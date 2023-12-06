<?php

namespace Model;

use PDO;

class Model
{
    protected static PDO $pdo;

    public static function getPDO()
    {
        //shablon almost as odinochka because create only one object
        if (isset(self::$pdo)) {
            return self::$pdo;
        }
        self::$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        return self::$pdo;
    }
}

