<?php

namespace Config;

use PDO;
use Exception;

class Database {
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct() {
        try {
            $this->connection = new PDO("mysql:host=localhost;dbname=fitgym__nutrition", "root");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}