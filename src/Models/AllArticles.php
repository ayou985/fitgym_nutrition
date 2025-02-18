<?php

namespace App\Models;

use PDO;
use App\Config\Database;

class AllArticles
{
    private $id;
    private $name;
    private $description;
    private $price;
    private $category_id;

    public function __construct($id = null, $name = "", $description = "", $price = 0, $category_id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category_id = $category_id;
    }

    public function getAllArticles()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->query("SELECT * FROM product");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleById()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->prepare("SELECT * FROM product WHERE id = ?");
        $query->execute([$this->id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function addArticle()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->prepare("INSERT INTO product (name, description, price, category_id) VALUES (?, ?, ?, ?)");
        return $query->execute([$this->name, $this->description, $this->price, $this->category_id]);
    }

    public function updateArticle()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->prepare("UPDATE product SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?");
        return $query->execute([$this->name, $this->description, $this->price, $this->category_id, $this->id]);
    }

    public function deleteArticle()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->prepare("DELETE FROM product WHERE id = ?");
        return $query->execute([$this->id]);
    }
}