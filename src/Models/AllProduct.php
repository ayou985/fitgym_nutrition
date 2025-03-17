<?php

namespace App\Models;

use Config\Database;
use PDO;

class AllProduct
{
    private ?int $id;
    private ?string $name;
    private ?string $description;
    private ?float $price;
    private ?int $stock;
    private ?string $category;
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

    // 🔹 **Getters**
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    // 🔹 **Setters**
    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function setStock(?int $stock): static
    {
        $this->stock = $stock;
        return $this;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    // 🔹 **Récupérer un produit par son ID**
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

    // 🔹 **Récupérer tous les produits**
    public static function getAll(): array
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        $sql = "SELECT * FROM product";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $products = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new AllProduct(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['stock'],
                $row['category'],
                $row['image']
            );
        }

        return $products;
    }

    // 🔹 **Mettre à jour un produit**
    public function edit(): bool
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        if ($this->id) {
            $sql = "UPDATE product SET name = ?, description = ?, price = ?, stock = ?, category = ?, image = ? WHERE id = ?";
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

    // 🔹 **Supprimer un produit**
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
