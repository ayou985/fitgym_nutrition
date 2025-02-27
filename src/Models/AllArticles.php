<?php

namespace App\Models;

use PDO;
use PDOException;

class Allarticles
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllArticles()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM articles");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des articles : " . $e->getMessage());
            return [];
        }
    }

    public function getArticleById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'article avec l'ID $id : " . $e->getMessage());
            return null;
        }
    }

    public function createArticle($titre, $contenu, $date_creation)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO articles (titre, contenu, date_creation) VALUES (?, ?, ?)");
            return $stmt->execute([$titre, $contenu, $date_creation]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la création de l'article : " . $e->getMessage());
            return false;
        }
    }

    public function updateArticle($id, $titre, $contenu, $date_creation)
    {
        try {
            $stmt = $this->db->prepare("UPDATE articles SET titre = ?, contenu = ?, date_creation = ? WHERE id = ?");
            return $stmt->execute([$titre, $contenu, $date_creation, $id]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'article avec l'ID $id : " . $e->getMessage());
            return false;
        }
    }

    public function deleteArticle($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM articles WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de l'article avec l'ID $id : " . $e->getMessage());
            return false;
        }
    }
}