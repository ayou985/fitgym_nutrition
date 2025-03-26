<?php

namespace App\Models;

use PDO;
use Config\Database;

require_once(__DIR__ . "/../../config/Database.php"); // ✅ Corrigé

class User
{
    protected ?int $id;
    protected ?string $email;
    protected ?string $password;
    protected ?string $firstName;
    protected ?string $lastName;
    protected ?string $phoneNumber;
    protected ?string $address;
    protected ?int $id_Role;
    protected ?string $profile_image = null;

    public function __construct(?int $id, ?string $email, ?string $password, ?string $firstName, ?string $lastName, ?string $phoneNumber, ?string $address, ?int $id_Role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->id_Role = $id_Role;
    }

    // ✅ INSCRIPTION (avec hachage du mot de passe)
    public function save(): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "INSERT INTO user (email, password, firstName, lastName, phoneNumber, address, id_Role) VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Hachage du mot de passe
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $statement = $pdo->prepare($sql);
        return $statement->execute([
            $this->email,
            $hashedPassword,
            $this->firstName,
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
        $sql = "SELECT * FROM user WHERE email = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$email]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            return new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['firstName'],
                $row['lastName'],
                $row['phoneNumber'],
                $row['address'],
                $row['id_Role']
            );
        }
        return null;
    }

    // ✅ RÉCUPÉRER UN UTILISATEUR PAR ID
    public static function getUserById($id): ?User
{
    $pdo = Database::getInstance()->getConnection();
    $sql = "SELECT * FROM user WHERE id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $user = new User(
            $row['id'],
            $row['email'],
            $row['password'],
            $row['firstName'],
            $row['lastName'],
            $row['phoneNumber'],
            $row['address'],
            $row['id_Role']
        );

        // On hydrate aussi l'image ici !
        $user->setProfileImage($row['profile_image'] ?? null);

        return $user;
    }
    return null;
    }

    // ✅ MISE À JOUR DU PROFIL
    public function updateUser(): bool
{
    $pdo = Database::getInstance()->getConnection();

    $sql = "UPDATE user 
            SET email = ?, 
                firstName = ?, 
                lastName = ?, 
                phoneNumber = ?, 
                address = ?, 
                profile_image = ?
            WHERE id = ?";

    $statement = $pdo->prepare($sql);

    return $statement->execute([
        $this->email,
        $this->firstName,
        $this->lastName,
        $this->phoneNumber,
        $this->address,
        $this->profile_image,
        $this->id
    ]);
    }

    // ✅ SUPPRESSION D'UN UTILISATEUR
    public function deleteUser(): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "DELETE FROM user WHERE id = ?";
        $statement = $pdo->prepare($sql);

        return $statement->execute([$this->id]);
    }

    // ✅ RÉCUPÉRER TOUS LES UTILISATEURS
    public static function getAll(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM user";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ CHANGER LE RÔLE D'UN UTILISATEUR (ex : user → admin)
    public static function updateRole(int $userId, int $newRole): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "UPDATE user SET id_Role = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$newRole, $userId]);
    }

    // ✅ CHANGER LE MOT DE PASSE D'UN UTILISATEUR

    public static function updatePassword($id, $hashedPassword)
    {
        $database = new Database(); // Create an instance of the Database class
        $db = $database->getConnection(); // Call the non-static method on the instance
        $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function userHasReviewed($userId, $productId): bool
    {
        $pdo = \Config\Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM review WHERE id_User = ? AND id_Product = ?");
        $stmt->execute([$userId, $productId]);
        return $stmt->fetchColumn() > 0;
    }
    public static function getByProductId($productId): array
    {
        $pdo = \Config\Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT r.*, u.firstName, u.lastName FROM review r JOIN user u ON r.id_User = u.id WHERE id_Product = ? ORDER BY created_at DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // 🔹 Getters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }
    public function getAddress(): ?string
    {
        return $this->address;
    }
    public function getIdRole(): ?int
    {
        return $this->id_Role;
    }

    // 🔹 Setters
    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }
    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }
    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
    public function setAddress(string $address): static
    {
        $this->address = $address;
        return $this;
    }
    public function setId_Role(int $id_Role): static
    {
        $this->id_Role = $id_Role;
        return $this;
    }
    public function getProfileImage()
    {
        return $this->profile_image ?? null;
    }
    public function setProfileImage($filename)
    {
        $this->profile_image = $filename;
    }
}
