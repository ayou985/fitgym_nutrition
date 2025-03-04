<?php

namespace Config;

use PDO;
use Exception;

class Database
{
    static function getConnection()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=fitgym__nutrition;charset=utf8', 'root');
        } catch (Exception $e) {
            die('Erreur :' . $e->getMessage());
        }
        return $pdo;
    }
}