<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    public static function getConnection() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=fitgym__nutrition", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
