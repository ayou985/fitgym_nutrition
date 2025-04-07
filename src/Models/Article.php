<?php

namespace App\Models;

use PDO;
use Config\Database;


class Article
{
    private $db;
    protected ?int $id;
    protected ?string $name;
    protected ?string $description;
    protected ?float $price;
    protected ?int $stock;
    protected ?string $category;

    public function __construct(?int $id = null, ?string $name = null, ?string $description = null, ?float $price = null, ?int $stock = null, ?string $category = null)
    {
        $this->db = Database::getInstance()->getConnection(); // Connexion à la BDD
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
    }

    public function save(): bool
    {
        $query = "INSERT INTO articles (name, description, price, stock, category) VALUES (:name, :description, :price, :stock, :category)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':category', $this->category);
        return $stmt->execute();
    }

    public static function getById($id): ?Article
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM articles WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Article($row['id'], $row['name'], $row['description'], $row['price'], $row['stock'], $row['category']);
        }
        return null;
    }

    public static function getAll(): array
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM articles";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(): bool
    {
        $query = "UPDATE articles SET name = :name, description = :description, price = :price, stock = :stock, category = :category WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public static function delete($id): bool
    {
        $db = Database::getInstance()->getConnection();
        $query = "DELETE FROM articles WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function getDescription(): ?string { return $this->description; }
    public function getPrice(): ?float { return $this->price; }
    public function getStock(): ?int { return $this->stock; }
    public function getCategory(): ?string { return $this->category; }

    // Setters
    public function setId(int $id): static { $this->id = $id; return $this; }
    public function setName(string $name): static { $this->name = $name; return $this; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }
    public function setPrice(float $price): static { $this->price = $price; return $this; }
    public function setStock(int $stock): static { $this->stock = $stock; return $this; }
    public function setCategory(string $category): static { $this->category = $category; return $this; }
}