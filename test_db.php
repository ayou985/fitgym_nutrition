<?php
// Fichier réservé au développement local — JAMAIS accessible en production
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

if (($_ENV['APP_ENV'] ?? 'production') !== 'development') {
    http_response_code(404);
    exit;
}

require_once 'vendor/autoload.php';
use Config\Database;

try {
    $db = Database::getInstance()->getConnection();
    echo "Connexion réussie.";
} catch (PDOException $e) {
    echo "Erreur de connexion.";
    error_log($e->getMessage());
}
