<?php

namespace App\Models;

use PDO;
use Config\Database;

class Product
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Ajouter un produit
    public function createProduct($name, $description, $price, $stock, $category, $image)
    {
        $sql = "INSERT INTO product (name, description, price, stock, category, image) 
                VALUES (:name, :description, :price, :stock, :category, :image)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':stock' => $stock,
            ':category' => $category,
            ':image' => $image
        ]);
    }

    // Récupérer tous les produits
    public function getAll()
    {
        $sql = "SELECT * FROM product";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un produit par son ID
    public function getById($id)
    {
        $sql = "SELECT * FROM product WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Mettre à jour un produit
    public function updateProduct($id, $name, $description, $price, $stock, $category, $image)
    {
        $sql = "UPDATE product SET 
                name = :name, 
                description = :description, 
                price = :price, 
                stock = :stock, 
                category = :category, 
                image = :image 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':stock' => $stock,
            ':category' => $category,
            ':image' => $image
        ]);
    }

    // Supprimer un produit
    public function deleteProduct($id)
    {
        $sql = "DELETE FROM product WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
