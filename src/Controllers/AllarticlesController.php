<?php


namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\AllArticles;

class AllArticlesController extends AbstractController
{
    public function index()
    {
        if ($_GET['id']) {
            $idArticle = $_GET['id'];
            $article = AllArticles::getById($idArticle);

            if (!$article) {
                $this->redirectToRoute('/');
            }

            require_once(__DIR__ . "/../Views/article/article.view.php");
        } else {
            $this->redirectToRoute('/');
        }
    }

    public function createArticle()
    {

        if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] == 1) {
            if (isset($_POST['name'])) {
                $this->check('name', $_POST['name']);
                $this->check('description', $_POST['description']);
                $this->check('price', $_POST['price']);
                $this->check('stock', $_POST['stock']);
                $this->check('category', $_POST['category']);

                if (empty($this->arrayError)) {
                    $name = htmlspecialchars($_POST['name']);
                    $description = htmlspecialchars($_POST['description']);
                    $price = htmlspecialchars($_POST['price']);
                    $stock = htmlspecialchars($_POST['stock']);
                    $category = htmlspecialchars($_POST['category']);

                    $article = new AllArticles(null, $name, $description, $price, $stock, $category);
                    $article->save();
                    $this->redirectToRoute('/');
                }

                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $targetDir = "uploads/"; // Dossier où stocker les images
                    $fileName = basename($_FILES["image"]["name"]);
                    $targetFilePath = $targetDir . $fileName;
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                
                    // Vérifier les formats autorisés
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        // Déplacer l'image dans le dossier
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                            $image = $fileName;
                        } else {
                            $image = null;
                        }
                    } else {
                        echo "Format d'image non supporté.";
                        exit;
                    }
                } else {
                    $image = null;
                }
            }

            require_once(__DIR__ . '/../Views/articles.create.view.php');
        } else {
            $this->redirectToRoute('/');
        }
    }

    public function store()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['price']) && !empty($_POST['stock']) && !empty($_POST['category'])) {

            // Sécurisation des entrées
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['price']);
            $stock = intval($_POST['stock']);
            $category = htmlspecialchars($_POST['category']);

            // Gestion de l'image
            $image = null; // Valeur par défaut
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = __DIR__ . "/../../public/uploads/"; // Assure-toi que ce dossier existe
                $fileName = time() . '_' . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                // Vérifier les formats autorisés
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($fileType, $allowTypes)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $image = $fileName;
                    }
                }
            }

            // Création et sauvegarde de l'article avec l'image
            $article = new AllArticles(null, $name, $description, $price, $stock, $category, $image);
            if ($article->save()) {
                header("Location: /admin/articles?success=1");
                exit();
            } else {
                header("Location: /admin/article/create?error=1");
                exit();
            }
        } else {
            header("Location: /admin/article/create?error=2");
            exit();
        }
    }
}

    public function editArticle()
    {
        if ($_GET['id']) {
            $idArticle = $_GET['id'];
            $article = AllArticles::getById($idArticle);

            if (!$article) {
                $this->redirectToRoute('/');
            }

            if (isset($_POST['name'])) {
                $this->check('name', $_POST['name']);
                $this->check('description', $_POST['description']);
                $this->check('price', $_POST['price']);
                $this->check('stock', $_POST['stock']);
                $this->check('category', $_POST['category']);

                if (empty($this->arrayError)) {
                    $name = htmlspecialchars($_POST['name']);
                    $description = htmlspecialchars($_POST['description']);
                    $price = htmlspecialchars($_POST['price']);
                    $stock = htmlspecialchars($_POST['stock']);
                    $category = htmlspecialchars($_POST['category']);

                    $article->setName($name)
                        ->setDescription($description)
                        ->setPrice($price)
                        ->setStock($stock)
                        ->setCategory($category)
                        ->update();
                    $this->redirectToRoute('/');
                }
            }

            require_once(__DIR__ . '/../Views/articles.edit.view.php');
        } else {
            $this->redirectToRoute('/');
        }
    }



    public function deleteArticle()
    {
        if (isset($_POST['id'])) {
            $idArticle = htmlspecialchars($_POST['id']);
            AllArticles::delete($idArticle);
            $this->redirectToRoute('/');
        }
    }
}
