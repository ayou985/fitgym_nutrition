<?php

namespace App\Controllers;

use App\Models\AllArticles;
use App\Config\Database;


class AllArticlesController
{

    public function index()
    {
        $articlesModel = new AllArticles(Database::getInstance());
        $articles = $articlesModel->getAllArticles();

        require_once 'views/allarticles.view.php';
    }

    // Afficher le formulaire de création
    public function create()
    {
        require_once __DIR__ . "/../Views/articles.create.view.php";
    }

    // Ajouter un article en base de données
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = new AllArticles(null, $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category_id']);
            $article->addArticle();
            header("Location: /admin/article"); // Redirection après ajout
            exit();
        }
    }

    // Afficher le formulaire d'édition
    public function edit()
    {
        $id = $_GET['id'];
        $article = (new AllArticles())->getArticleById($id);
        require_once __DIR__ . "/../Views/articles.edit.view.php";
    }

    // Mettre à jour un article
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = new AllArticles($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category_id']);
            $article->updateArticle();
            header("Location: /admin/article");
            exit();
        }
    }

    // Supprimer un article
    public function delete()
    {
        $id = $_GET['id'];
        $article = new AllArticles($id);
        $article->deleteArticle();
        header("Location: /admin/article");
        exit();
    }
}
