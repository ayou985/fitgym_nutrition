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

    public function createProduct($name, $description, $price, $image)
    {
        $pdo = Database::getConnection();   
        $sql = "INSERT INTO product (name, description, price, image) VALUES (:name, :description, :price, :image)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':image' => $image
        ]);
    }

    public function create($name, $description, $price, $stock, $category, $image)
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

    public function getAllProduct()
    {
        $sql = "SELECT * FROM product";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOne($id)
    {
        $sql = "SELECT * FROM product WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $description, $price, $image)
    {
        $sql = "UPDATE product SET name = :name, description = :description, price = :price, image = :image WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':image' => $image
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM product WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
