<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class User
{
    private PDO $db;

    public function __construct(
        private string $email,
        private string $password,
        private string $firstName,
        private string $lastName,
        private int $id_Role,
        private int $id = 0, // ID optionnel, valeur par défaut
        private ?string $address = null, // Doit être après les paramètres obligatoires
        private ?string $phone = null    // Doit être après les paramètres obligatoires
    ) {
        $this->db = Database::getConnection();
    }

    // ✅ Authentification utilisateur
    public static function authenticate(string $email, string $password): ?User
    {
        $user = self::getUserByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }

    // ✅ Récupérer un utilisateur par email
    public static function getUserByEmail(string $email): ?User
    {
        try {
            $db = Database::getConnection();
            $query = "SELECT email, password, firstName, lastName, id_Role, id, 
                            COALESCE(address, '') as address, COALESCE(phone, '') as phone
                    FROM users WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->execute(['email' => $email]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                return new User(
                    $userData['email'],
                    $userData['password'],
                    $userData['firstName'],
                    $userData['lastName'],
                    $userData['id_Role'],
                    $userData['id'],
                    $userData['address'] ?: null, // Convertit '' en NULL
                    $userData['phone'] ?: null    // Convertit '' en NULL
                );
            }
            return null;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // ✅ Récupérer tous les utilisateurs
    public function getAll(): array
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
    require_once __DIR__ . '/../Config/Database.php';


