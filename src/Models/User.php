<?php

namespace App\Models;

use PDO;
use Config\DataBase;

class User
{
    protected ?int $id;
    protected ?string $email;
    protected ?string $password;
    protected ?string $firstName;
    protected ?string $lastName;
    protected ?int $phoneNumber;
    protected ?string $address;
    protected int|string|null $id_Role;

    public function __construct(?int $id, ?string $email, ?string $password, ?string $firstName, ?string $lastName, ?int $phoneNumber, ?string $address, int|string|null $id_Role)
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
        $pdo = DataBase::getConnection();
        $sql = "INSERT INTO user (id, email, password, firstName, lastName, phoneNumber, address, id_Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->id, $this->email, $this->password, $this->firstName, $this->lastName, $this->phoneNumber, $this->address, $this->id_Role]);
    }

    public static function getUserByEmail($email): ?User
    {
        $db = DataBase::getConnection();
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

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

    public function getUserById(): ?User
    {
        $pdo = DataBase::getConnection();
        $sql = "SELECT * FROM user WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$this->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User($row['id'], $row['email'], $row['password'], $row['firstName'], $row['lastName'], $row['phoneNumber'], $row['address'], $row['id_Role']);
        }
        return null;
    }

    public static function getUsers(): array
    {
        $pdo = DataBase::getConnection();
        $sql = "SELECT id, email FROM user WHERE id_Role = 2";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($result as $row) {
            $users[] = new User($row['id'], $row['email'], null, null, null, null, null, null);
        }

        return $users;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getIdRole(): int|string|null
    {
        return $this->id_Role;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public static function authenticate($email, $password): ?User
    {
        $user = self::getUserByEmail($email); // Récupère l'utilisateur par email

        if ($user && password_verify($password, $user->getPassword())) {
            return $user; // Retourne l'utilisateur si le mot de passe est correct
        }

        return null; // Retourne null si l'authentification échoue
    }
}