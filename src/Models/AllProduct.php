<?php

namespace App\Models;

use Config\Database;
use PDO;

class AllProduct
{
    private ?int $id;
    private string $name;
    private string $description;
    private float $price;
    private int $stock;
    private string $category;
    private ?string $image;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $description = null,
        ?float $price = null,
        ?int $stock = null,
        ?string $category = null,
        ?string $image = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
        $this->image = $image;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getStock(): int { return $this->stock; }
    public function getCategory(): string { return $this->category; }
    public function getImage(): ?string { return $this->image; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setPrice(float $price): void { $this->price = $price; }
    public function setStock(int $stock): void { $this->stock = $stock; }
    public function setCategory(string $category): void { $this->category = $category; }
    public function setImage(?string $image): void { $this->image = $image; }

    // Récupérer un produit par son ID
    public static function getById(int $id): ?AllProduct
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        $sql = "SELECT * FROM product WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        // Création d'un objet AllProduct
        $product = new AllProduct();
        $product->setId($row['id']);
        $product->setName($row['name']);
        $product->setDescription($row['description']);
        $product->setPrice($row['price']);
        $product->setStock($row['stock']);
        $product->setCategory($row['category']);
        $product->setImage($row['image']);

        return $product;
    }

    // Récupérer tous les produits
    public static function getAll(): array
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        $sql = "SELECT * FROM product";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $products = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $product = new AllProduct();  // Initialisation d'un nouveau produit pour chaque ligne
            $product->setId($row['id']);
            $product->setName($row['name']);
            $product->setDescription($row['description']);
            $product->setPrice($row['price']);
            $product->setStock($row['stock']);
            $product->setCategory($row['category']);
            $product->setImage($row['image']);
            $products[] = $product;  // Ajout du produit dans le tableau
        }

        return $products;
    }

    // Enregistrer ou mettre à jour un produit
    public function update(): bool
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        if ($this->id) {
            // Mise à jour d'un produit existant
            $sql = "UPDATE product SET name = ?, description = ?, price = ?, stock = ?, category = ?, image = ?, updatedAt = NOW() WHERE id = ?";
            $statement = $pdo->prepare($sql);
            return $statement->execute([
                $this->name,
                $this->description,
                $this->price,
                $this->stock,
                $this->category,
                $this->image,
                $this->id
            ]);
        } else {
            // Création d'un nouveau produit
            $sql = "INSERT INTO product (name, description, price, stock, category, image) VALUES (?, ?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($sql);
            return $statement->execute([
                $this->name,
                $this->description,
                $this->price,
                $this->stock,
                $this->category,
                $this->image
            ]);
        }
    }

    // Supprimer un produit
    public function delete(): bool
    {
        if (!$this->id) {
            return false;
        }

        $db = Database::getInstance();
        $pdo = $db->getConnection();

        $sql = "DELETE FROM product WHERE id = ?";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->id]);
    }
}
