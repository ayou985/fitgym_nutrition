<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\AllProduct;

class AllProductController extends AbstractController
{
    public function index()
    {
        $products = AllProduct::getAll();
        require_once(__DIR__ . '/../Views/product.view.php');
    }

    public function createProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification des champs requis
            if (!isset($_POST['name']) || trim($_POST['name']) === '') {
                $_SESSION['error'] = "Le nom du produit est obligatoire.";
                $this->redirectToRoute('/products');
            }

            // chemin du dossier des images
            $target_dir = "public/uploads/";

            // Récupération et sécurisation des données
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);
            $category = htmlspecialchars($_POST['category'] ?? '');
            // chemin plus le nom de l'image
            $target_file = $target_dir . basename($_FILES["image"]["name"]);

            // si mon image a bien été déplacé 
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // alors ma variable contient le nom de l'image si mon utilisateur a ajouté une image
                $img = htmlspecialchars(basename($_FILES["image"]["name"]));
                // Création du produit
                $product = new AllProduct(null, $name, $description, $price, $stock, $category, $img);
                $product->createProduct();
            } 
        }
        require_once(__DIR__ . '/../Views/admin.product.create.view.php');
    }

    public function editProduct()
    {
        if (!isset($_GET['id'])) {
            $this->redirectToRoute('/products');
        }

        $id = intval($_GET['id']);
        $product = AllProduct::getById($id);

        if (!$product) {
            $_SESSION['error'] = "Produit introuvable.";
            $this->redirectToRoute('/products');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);
            $category = htmlspecialchars($_POST['category'] ?? '');

            // Garder l'ancienne image par défaut
            $image = $product->getImage();

            if (!empty($_FILES['image']['name'])) {
                $imageName = basename($_FILES['image']['name']);
                $targetDir = __DIR__ . '/../../public/uploads/';
                $targetFilePath = $targetDir . $imageName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $image = "/uploads/" . $imageName;
                }
            }
            // Vérifier que c'est bien une image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (in_array($_FILES['image']['type'], $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $image = "/uploads/" . $imageName; // Stocker le chemin dans la BDD
                } else {
                    $_SESSION['error'] = "Échec du téléchargement de l'image.";
                }
            } else {
                $_SESSION['error'] = "Type de fichier non autorisé.";
            }

            // Si aucune image existante, mettre une image par défaut
            if (empty($image)) {
                $image = "/uploads/default.jpg";
            }

            $product->setName($name);
            $product->setDescription($description);
            $product->setPrice($price);
            $product->setStock($stock);
            $product->setCategory($category);
            $product->setImage($image);

            if ($product->edit()) {
                $_SESSION['success'] = "Produit mis à jour avec succès.";
                $this->redirectToRoute('/products');
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour.";
            }

            // chemin du dossier des images
            $target_dir = "public/uploads/";

            // Récupération et sécurisation des données
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);
            $category = htmlspecialchars($_POST['category'] ?? '');
            // chemin plus le nom de l'image
            $target_file = $target_dir . basename($_FILES["image"]["name"]);

            // si mon image a bien été déplacé 
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // alors ma variable contient le nom de l'image si mon utilisateur a ajouté une image
                $img = htmlspecialchars(basename($_FILES["image"]["name"]));
                // Création du produit
                $product = new AllProduct(null, $name, $description, $price, $stock, $category, $img);
                $product->createProduct();
            }
        }

        require_once(__DIR__ . '/../Views/admin.product.edit.view.php');
    }

    public function deleteProduct()
    {

        if (isset($_GET['id'])) {
            $idPost = $_GET['id'];
            $product = new AllProduct($idPost);
            $product->delete();
            $this->redirectToRoute('/products');
        } else {
            $this->redirectToRoute('/products');
        }
    }
}
