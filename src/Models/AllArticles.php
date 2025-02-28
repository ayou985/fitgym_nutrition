<?php

namespace App\Models;

use PDO;
use App\Config\Database;

class AllArticles
{
    protected ?int $id;
    protected ?string $name;
    protected ?string $description;
    protected ?float $price;
    protected ?int $stock;
    protected ?string $category;
    protected ?string $image; // Ajout de l'attribut image

    public function __construct(?int $id, ?string $name, ?string $description, ?float $price, ?int $stock, ?string $category, ?string $image = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
        $this->image = $image; // Initialisation de l'image
    }

    public function save(): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "INSERT INTO articles (name, description, price, stock, category, image) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->name, $this->description, $this->price, $this->stock, $this->category, $this->image]);
    }

    public static function getById($id): ?AllArticles
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM articles WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new AllArticles(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['stock'],
                $row['category'],
                $row['image'] // Récupération de l'image
            );
        }
        return null;
    }

    public static function getAll(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM articles";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "UPDATE articles SET name = ?, description = ?, price = ?, stock = ?, category = ?, image = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->name, $this->description, $this->price, $this->stock, $this->category, $this->image, $this->id]);
    }

    public static function delete($id): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $sql = "DELETE FROM articles WHERE id = ?";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$id]);
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function getDescription(): ?string { return $this->description; }
    public function getPrice(): ?float { return $this->price; }
    public function getStock(): ?int { return $this->stock; }
    public function getCategory(): ?string { return $this->category; }
    public function getImage(): ?string { return $this->image; } // Getter pour l'image

    // Setters
    public function setId(int $id): static { $this->id = $id; return $this; }
    public function setName(string $name): static { $this->name = $name; return $this; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }
    public function setPrice(float $price): static { $this->price = $price; return $this; }
    public function setStock(int $stock): static { $this->stock = $stock; return $this; }
    public function setCategory(string $category): static { $this->category = $category; return $this; }
    public function setImage(string $image): static { $this->image = $image; return $this; } // Setter pour l'image
}

require_once(__DIR__ . "/../../config/Database.php");
