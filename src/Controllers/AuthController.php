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

    public function save(): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "INSERT INTO users (email, password, username, lastName, phoneNumber, address, id_Role) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->email, $this->password, $this->username, $this->lastName, $this->phoneNumber, $this->address, $this->id_Role]);
    }

    public static function authenticate($email, $password): ?User
    {
        $pdo = \Config\Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            return new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['username'],
                $row['lastName'],
                $row['phoneNumber'],
                $row['address'],
                $row['id_Role']
            );
        }

        return null;
    }


    public static function getUserByEmail($email): ?User
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM users WHERE email = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$email]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['username'],
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
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM users WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['username'],
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
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM user";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateRole(int $userId, int $newRole): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "UPDATE user SET id_Role = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$newRole, $userId]);
    }

    // Getters
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
    public function getusername(): ?string
    {
        return $this->username;
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
    public function getId_Role(): ?int
    {
        return $this->id_Role;
    }

    // Setters
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
    public function setusername(string $username): static
    {
        $this->username = $username;
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
}
