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
    protected int |null $phoneNumber;
    protected string|null $address;
    protected int|string|null $id_Role;

    public function __construct(?int $id, ?string $email, ?string $password, ?string $firstName,?string $lastName,int|null $phoneNumber,string|null $address,  int|string|null $id_Role)
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
        $sql = "INSERT INTO user (id,email,password,firstName,lastName,phoneNumber,address,id_Role	) VALUES (?,?,?,?,?,?,?,?)";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->id, $this->email, $this->password, $this->firstName, $this->lastName, $this->phoneNumber,$this->address, $this->id_Role]);
    }

    public function login($mail)
    {
        $pdo = DataBase::getConnection();
        $sql = "SELECT * FROM `user` WHERE `mail` = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$mail]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row['id_role'] == 2) {
            return new User($row['id'], $row['email'], $row['password'], $row['firstName'], $row['lastName'], $row['phoneNumber'], $row['address'], $row['id_Role']);
        } elseif ($row['id_role'] == 2) {
            return new User($row['id'], $row['email'], $row['password'], $row['firstName'], $row['lastName'], $row['phoneNumber'], $row['address'], $row['id_Role'] );
        } else {
            return null;
        }
    }

    public function getUserById()
    {
        $pdo = DataBase::getConnection();
        $sql = "SELECT * FROM `user` WHERE `id` = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$this->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['id'], $row['email'], $row['password'], $row['firstName'], $row['lastName'], $row['phoneNumber'], $row['address'], $row['id_Role']);
        } else {
            return null;
        }
    }

    public function getUser()
    {
        $pdo = DataBase::getConnection();
        $sql = "SELECT `user`.`id`, `user`.`email` FROM `user` WHERE `user`.`id_role` = 2";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $kids = [];
        foreach ($result as $row) {
            $register = new User($row['id'], $row['email'], null, null, null, null, null, null);
            $registers[] = $register;
        }
        return $registers;
    }

    
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
    
    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }
    
    public function getAddress(): ?string
    {
        return $this->address;
    }
    
    public function getIdRole(): int|string|null
    {
        return $this->id_Role;
    }
    
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
    
    public function setPhoneNumber(?int $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
    
    public function setAddress(?string $address): static
    {
        $this->address = $address;
        return $this;
    }
    
    public function setIdRole(int|string|null $id_Role): static
    {
        $this->id_Role = $id_Role;
        return $this;
    }
}
