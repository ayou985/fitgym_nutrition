<?php
require_once 'vendor/autoload.php';
use Config\Database;

try {
    $db = Database::getInstance()->getConnection();
    echo "Connexion réussie.";
    var_dump($db);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}