<?php

namespace App\Models;

use PDO;

class AllArticles
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllArticles()
    {
        $stmt = $this->db->query("SELECT * FROM articles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addArticle($name, $description, $price, $category_id)
    {
        $stmt = $this->db->prepare("INSERT INTO articles (name, description, price, category_id) VALUES (:name, :description, :price, :category_id)");
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id
        ]);
    }

    public function updateArticle($id, $name, $description, $price, $category_id)
    {
        $stmt = $this->db->prepare("UPDATE articles SET name = :name, description = :description, price = :price, category_id = :category_id WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id
        ]);
    }

    public function deleteArticle($id)
    {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}