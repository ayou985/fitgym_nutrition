<?php

namespace App\Models;

use PDO;
use Config\Database;

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

    public function save(): bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO user (email, password, firstName, lastName, phoneNumber, address, id_Role) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->email, $this->password, $this->firstName, $this->lastName, $this->phoneNumber, $this->address, $this->id_Role]);
    }

    public static function authenticate($email, $password): ?User
    {
        $pdo = Database::getConnection();
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

    public static function getUserById($id): ?User
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM user WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
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

    public static function getAll(): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM user";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateRole(int $userId, int $newRole): bool
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE user SET id_Role = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$newRole, $userId]);
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getEmail(): ?string { return $this->email; }
    public function getPassword(): ?string { return $this->password; }
    public function getFirstName(): ?string { return $this->firstName; }
    public function getLastName(): ?string { return $this->lastName; }
    public function getPhoneNumber(): ?string { return $this->phoneNumber; }
    public function getAddress(): ?string { return $this->address; }
    public function getIdRole(): ?int { return $this->id_Role; }

    // Setters
    public function setId(int $id): static { $this->id = $id; return $this; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }
    public function setPassword(string $password): static { $this->password = $password; return $this; }
    public function setFirstName(string $firstName): static { $this->firstName = $firstName; return $this; }
    public function setLastName(string $lastName): static { $this->lastName = $lastName; return $this; }
    public function setPhoneNumber(string $phoneNumber): static { $this->phoneNumber = $phoneNumber; return $this; }
    public function setAddress(string $address): static { $this->address = $address; return $this; }
    public function setIdRole(int $id_Role): static { $this->id_Role = $id_Role; return $this; }
}

require_once(__DIR__ . "/../../config/Database.php");
