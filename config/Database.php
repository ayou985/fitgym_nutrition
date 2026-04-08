<?php

namespace Config;

use PDO;
use Exception;

class Database {
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct() {
        try {
            $host   = $_ENV['DB_HOST'] ?? 'localhost';
            $dbname = $_ENV['DB_NAME'] ?? 'fitgym__nutrition';
            $user   = $_ENV['DB_USER'] ?? 'root';
            $pass   = $_ENV['DB_PASS'] ?? '';
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            error_log("Erreur de connexion BDD : " . $e->getMessage());
            die("Erreur de connexion à la base de données.");
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