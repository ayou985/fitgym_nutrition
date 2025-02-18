<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\AllArticle;

class AllArticleController extends AbstractController
{
    public function index()
    {
        $articles = (new AllArticle())->getAllArticles();
        require_once(__DIR__ . "/../Views/allarticle/index.view.php");
    }

    public function show()
    {
        if (isset($_GET['id'])) {
            $article = (new AllArticle($_GET['id']))->getArticleById();
            require_once(__DIR__ . "/../Views/allarticle/show.view.php");
        } else {
            $this->redirectToRoute('/allarticle');
        }
    }

    public function create()
    {
        if (isset($_POST['name'])) {
            $article = new AllArticle(null, $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category_id']);
            $article->addArticle();
            $this->redirectToRoute('/allarticle');
        }
        require_once(__DIR__ . "/../Views/allarticle/create.view.php");
    }

    public function edit()
    {
        if (isset($_GET['id'])) {
            $article = (new AllArticle($_GET['id']))->getArticleById();

            if (isset($_POST['name'])) {
                $updatedArticle = new AllArticle($_GET['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category_id']);
                $updatedArticle->updateArticle();
                $this->redirectToRoute('/allarticle');
            }

            require_once(__DIR__ . "/../Views/allarticle/edit.view.php");
        } else {
            $this->redirectToRoute('/allarticle');
        }
    }

    public function delete()
    {
        if (isset($_POST['id'])) {
            (new AllArticle($_POST['id']))->deleteArticle();
            $this->redirectToRoute('/allarticle');
        }
    }
}
