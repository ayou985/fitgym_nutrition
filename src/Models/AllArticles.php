<?php

namespace App\Models;

use PDO;
use PDOException;

class AllArticle {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=fitgym_nutrition", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // 🔹 Ajout d'un article
    public function store() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!isset($_POST["titre"]) || !isset($_POST["contenu"])) {
                die("Erreur : Données manquantes !");
            }

            $titre = trim($_POST["titre"]);
            $contenu = trim($_POST["contenu"]);

            if (empty($titre) || empty($contenu)) {
                die("Erreur : Tous les champs doivent être remplis !");
            }

            try {
                // Vérifier si la table existe avant d'insérer
                $checkTable = $this->pdo->query("SHOW TABLES LIKE 'articles'");
                if ($checkTable->rowCount() == 0) {
                    die("Erreur : La table 'articles' n'existe pas !");
                }

                // Requête d'insertion
                $sql = "INSERT INTO articles (titre, contenu) VALUES (:titre, :contenu)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(":titre", $titre);
                $stmt->bindParam(":contenu", $contenu);

                if ($stmt->execute()) {
                    header("Location: index.php");
                    exit();
                } else {
                    die("Erreur lors de l'ajout !");
                }
            } catch (PDOException $e) {
                die("Erreur SQL : " . $e->getMessage());
            }
        }
    }
}

// Instancier et exécuter la méthode store()
$article = new AllArticle();
$article->store();
?>
