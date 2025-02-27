<?php

namespace App\Controllers;

use App\Models\Allarticles;
use PDO;

class AllarticlesController
{
    private $model;

    public function __construct(PDO $db)
    {
        $this->model = new Allarticles($db);
    }

    public function index()
    {
        $articles = $this->model->getAllArticles();
        // Logique pour afficher les articles (par exemple, les passer à une vue)
        var_dump($articles); // Exemple : afficher les articles
    }

    public function show($id)
    {
        $article = $this->model->getArticleById($id);
        // Logique pour afficher un article (par exemple, le passer à une vue)
        var_dump($article); // Exemple : afficher l'article
    }

    public function create()
    {
        // Logique pour afficher le formulaire de création d'article
        // ...

        // Exemple : récupération des données du formulaire
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $date_creation = date('Y-m-d H:i:s'); // Date actuelle

        if ($this->model->createArticle($titre, $contenu, $date_creation)) {
            echo "Article créé avec succès.";
            // Redirection ou autre logique
        } else {
            echo "Erreur lors de la création de l'article.";
        }
    }

    public function update($id)
    {
        // Logique pour afficher le formulaire de mise à jour d'article
        // ...

        // Exemple : récupération des données du formulaire
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $date_creation = date('Y-m-d H:i:s'); // Date actuelle

        if ($this->model->updateArticle($id, $titre, $contenu, $date_creation)) {
            echo "Article mis à jour avec succès.";
            // Redirection ou autre logique
        } else {
            echo "Erreur lors de la mise à jour de l'article.";
        }
    }

    public function delete($id)
    {
        if ($this->model->deleteArticle($id)) {
            echo "Article supprimé avec succès.";
            // Redirection ou autre logique
        } else {
            echo "Erreur lors de la suppression de l'article.";
        }
    }
}