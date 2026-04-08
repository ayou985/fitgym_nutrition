<?php

namespace App\Models;

use PDO;
use Config\Database;

class User
{
    protected ?int $id;
    protected ?string $email;
    protected ?string $password;
    protected ?string $username;
    protected ?string $lastName;
    protected ?string $phoneNumber;
    protected ?string $address;
    protected ?int $id_Role;
    protected ?string $profile_image = null;

    public function __construct(?int $id, ?string $email, ?string $password, ?string $username, ?string $lastName, ?string $phoneNumber, ?string $address, ?int $id_Role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->id_Role = $id_Role;
    }

    // ✅ INSCRIPTION
    public function save(): bool
    {
        $pdo = \Config\Database::getInstance()->getConnection();
        $sql = "INSERT INTO users (email, password, username, lastName, phoneNumber, address, id_Role)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $statement = $pdo->prepare($sql);
        return $statement->execute([
            $this->email,
            $this->password, 
            $this->username,
            $this->lastName,
            $this->phoneNumber,
            $this->address,
            $this->id_Role
        ]);
    }

    // ✅ AUTHENTIFICATION
    public static function authenticate($email, $password): ?User
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            $user = new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['username'],
                $row['lastName'],
                $row['phoneNumber'],
                $row['address'],
                $row['id_Role']
            );
            $user->setProfileImage($row['profile_image'] ?? null);
            return $user;
        }

        return null;
    }

    // ✅ RÉCUPÉRER UN UTILISATEUR PAR ID
    public static function getUserById($id): ?User
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM users WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $user = new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['username'],
                $row['lastName'],
                $row['phoneNumber'],
                $row['address'],
                $row['id_Role']
            );
            $user->setProfileImage($row['profile_image'] ?? null);
            return $user;
        }

        return null;
    }

    // ✅ MISE À JOUR DU PROFIL (Correction 'users')
    public function updateUser(): bool
    {
        $pdo = Database::getInstance()->getConnection();

        $sql = "UPDATE users SET 
            email = :email,
            username = :username,
            lastName = :lastName,
            phoneNumber = :phoneNumber,
            address = :address,
            id_Role = :id_Role,
            profile_image = :profile_image
            WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':email' => $this->email,
            ':username' => $this->username,
            ':lastName' => $this->lastName,
            ':phoneNumber' => $this->phoneNumber,
            ':address' => $this->address,
            ':id_Role' => $this->id_Role,
            ':profile_image' => $this->profile_image,
            ':id' => $this->id
        ]);
    }

    // ✅ SUPPRESSION D'UN UTILISATEUR
    public function deleteUser(): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "DELETE FROM users WHERE id = ?";
        $statement = $pdo->prepare($sql);

        return $statement->execute([$this->id]);
    }

    // ✅ RÉCUPÉRER TOUS LES UTILISATEURS
    public static function getAll(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM users";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ CHANGER LE RÔLE
    public static function updateRole(int $userId, int $newRole): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "UPDATE users SET id_Role = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$newRole, $userId]);
    }

    // ✅ CHANGER LE MOT DE PASSE
    public static function updatePassword($id, $hashedPassword)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // ✅ REVIEWS / AVIS
    public static function userHasReviewed($userId, $product_id): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE id_User = ? AND id_Product = ?");
        $stmt->execute([$userId, $product_id]);
        return $stmt->fetchColumn() > 0;
    }

    public static function getByProductId($product_id): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT r.*, u.username, u.lastName FROM reviews r JOIN users u ON r.id_User = u.id WHERE id_Product = ? ORDER BY created_at DESC");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Getters
    public function getId(): ?int { return $this->id; }
    public function getEmail(): ?string { return $this->email; }
    public function getPassword(): ?string { return $this->password; }
    public function getusername(): ?string { return $this->username; }
    public function getLastName(): ?string { return $this->lastName; }
    public function getPhoneNumber(): ?string { return $this->phoneNumber; }
    public function getAddress(): ?string { return $this->address; }
    public function getIdRole(): ?int { return $this->id_Role; }
    public function getProfileImage() { return $this->profile_image; }

    // 🔹 Setters
    public function setEmail(string $email): static { $this->email = $email; return $this; }
    public function setusername(string $username): static { $this->username = $username; return $this; }
    public function setLastName(string $lastName): static { $this->lastName = $lastName; return $this; }
    public function setPhoneNumber(string $phoneNumber): static { $this->phoneNumber = $phoneNumber; return $this; }
    public function setAddress(string $address): static { $this->address = $address; return $this; }
    public function setId_Role(int $id_Role): static { $this->id_Role = $id_Role; return $this; }
    public function setProfileImage(?string $filename) { $this->profile_image = $filename; }
}