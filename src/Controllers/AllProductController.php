<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\AllProduct;
use App\Models\Product;

class AllProductController extends AbstractController
{
    // Afficher un produit (Read)
    public function index()
    {
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            $this->redirectToRoute('/product');
            exit;
        }

        $idProduct = intval($_GET['id']);
        $product = AllProduct::getById($idProduct);

        if (!$product) {
            $this->redirectToRoute('/product');
            exit;
        }

        require_once(__DIR__ . '/../Views/admin.product.view.php');
    }
    public function viewProduct($id)
    {
        // Vérifie si l'ID est bien reçu
        if (!isset($id)) {
            die("Erreur : ID manquant !");
        }

        // Crée une instance du modèle ProductModel
        $product = new Product();

        // Récupère le produit par son ID
        $product = $product->getProductById($id);

        if (!$product) {
            die("Erreur : Produit introuvable !");
        }

        // Inclut la vue pour afficher les détails du produit
        require_once __DIR__ . '/../Views/admin/product/view.php';
    }

    // Créer un produit (Create)
    public function createProduct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
            $this->redirectToRoute('/product/create');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['price']);
            $stock = intval($_POST['stock']);
            $category = htmlspecialchars($_POST['category']);

            $image = $this->handleImageUpload();

            $product = new AllProduct(null, $name, $description, $price, $stock, $category, $image);
            if ($product->save()) {
                $this->redirectToRoute('/product/create');
                exit;
            }
        }

        require_once(__DIR__ . '/../Views/admin.product.create.view.php');
    }

    // Supprimer un produit (Delete)
    public function deleteProduct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
            $this->redirectToRoute('/product/delete');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id']) && ctype_digit($_POST['id'])) {
            $idProduct = intval($_POST['id']);
            if (AllProduct::delete($idProduct)) {
                $this->redirectToRoute('/product/delete');
                exit;
            }
        }

        $this->redirectToRoute('/product/list');
        exit;

        require_once(__DIR__ . '/../Views/admin.product.delete.view.php');
    }


    // Modifier un produit (Update)
    public function updateProduct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
            $this->redirectToRoute('/product/edit');
            exit;
        }

        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            $this->redirectToRoute('/product/edit');
            exit;
        }

        $idProduct = intval($_GET['id']);
        $product = AllProduct::getById($idProduct);

        if (!$product) {
            $this->redirectToRoute('/product/edit');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['price']);
            $stock = intval($_POST['stock']);
            $category = htmlspecialchars($_POST['category']);

            $image = $product->getImage();

            $updatedProduct = new AllProduct($idProduct, $name, $description, $price, $stock, $category, $image);
            if ($updatedProduct->update()) {
                $this->redirectToRoute('/product/edit');
                exit;
            }
        }

        require_once(__DIR__ . '/../Views/admin.product.edit.view.php');
    }

    // Gérer l'upload des images
    private function handleImageUpload()
    {
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
            $targetDir = __DIR__ . "/../../public/uploads/";
            $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($fileType), $allowedTypes)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    return $fileName;
                }
            }
        }
        return null;
    }
}
