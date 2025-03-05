<?php

namespace App\Models;

use Config\Database;
use PDO;

class AllProduct
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $category;
    public $image;
    public $createdAt;
    public $updatedAt;

    public function __construct(
        $id = null,
        $name = null,
        $description = null,
        $price = null,
        $stock = null,
        $category = null,
        $image = null,
        $createdAt = null,
        $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
        $this->image = $image;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Méthodes pour définir les propriétés
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

    // Méthodes pour récupérer les propriétés
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getImage()
    {
        return $this->image;
    }

    // Méthodes pour la base de données
    public function save(): bool
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        if ($this->id) {
            // Mise à jour d'un produit existant
            $sql = "UPDATE product SET name = ?, description = ?, price = ?, stock = ?, category = ?, image = ?, WHERE id = ?";
            $statement = $pdo->prepare($sql);
            return $statement->execute([$this->name, $this->description, $this->price, $this->stock, $this->category, $this->image, $this->id]);
        } else {
            // Création d'un nouveau produit
            $sql = "INSERT INTO product (name, description, price, stock, category, image) VALUES (?, ?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($sql);
            return $statement->execute([$this->name, $this->description, $this->price, $this->stock, $this->category, $this->image]);
        }
    }

    public static function getById($id): ?AllProduct
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

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
                $row['image'],
                $row['createdAt'],
                $row['updatedAt']
            );
        }

        return null;
    }

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
                $row['image'],
                $row['createdAt'],
                $row['updatedAt']
            );
        }

        return $products;
    }

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