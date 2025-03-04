<?php

namespace App\Models;

use PDO;
use Config\Database;

class AllProduct
{
    protected ?int $id;
    protected ?string $name;
    protected ?string $description;
    protected ?float $price;
    protected ?int $stock;
    protected ?string $category;
    protected ?string $image;

    public function __construct(?int $id, ?string $name, ?string $description, ?float $price, ?int $stock, ?string $category, ?string $image = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
        $this->image = $image;
    }
        // ✅ Ajout des GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    // ✅ Ajout des SETTERS si nécessaire
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function setStock(int $stock)
    {
        $this->stock = $stock;
    }

    public function setCategory(string $category)
    {
        $this->category = $category;
    }

    public function setImage(string $image)
    {
        $this->image = $image;
    }


    public function save(): bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO products (name, description, price, stock, category, image) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->name, $this->description, $this->price, $this->stock, $this->category, $this->image]);
    }

    public static function getById($id): ?AllProduct
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM product WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        

        if ($row) {
            return new AllProduct(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['stock'],
                $row['category'],
                $row['image']
            );
        }
        return null;
    }

    public static function getAll(): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM product";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(): bool
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category = ?, image = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->name, $this->description, $this->price, $this->stock, $this->category, $this->image, $this->id]);
    }

    public static function delete($id): bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM products WHERE id = ?";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$id]);
    }
    
}


require_once(__DIR__ . "/../../config/Database.php");
