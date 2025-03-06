<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\AllProduct;

class AllProductController extends AbstractController
{
    // Afficher un produit (Read)
    public function index()
    {
        // ... (votre code pour afficher tous les produits)
        require_once(__DIR__ . '/../Views/product.view.php');
    }

    public function viewProduct($id)
    {
        // Vérifie si l'ID est bien reçu
        if (!isset($id)) {
            die("Erreur : ID manquant !");
        }

        // Récupère le produit par son ID avec AllProduct
        $product = AllProduct::getById($id);

        if (!$product) {
            die("Erreur : Produit introuvable !");
        }

        // Inclut la vue pour afficher les détails du produit
        require_once __DIR__ . '/../Views/admin.product.view.php';
    }

    // Créer un produit (Create)
    public function createProduct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
            $this->redirectToRoute('/ createProduct');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['price']);
            $stock = intval($_POST['stock']);
            $category = htmlspecialchars($_POST['category']);

            $image = $this->handleImageUpload();

            $product = new AllProduct();
            if ($product->save()) {
                $this->redirectToRoute('/ createProduct');
                exit;
            }
        }

        require_once(__DIR__ . '/../Views/admin.product.create.view.php');
    }

    // Modifier un produit (Update)
    public function updateProduct($id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
            $this->redirectToRoute('/updateProduct?id=' . $id);
            exit;
        }

        $product = AllProduct::getById($id);

        if (!$product) {
            $this->redirectToRoute('/updateProduct?id=' . $id);
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['price']);
            $stock = intval($_POST['stock']);
            $category = htmlspecialchars($_POST['category']);

            $image = $product->getImage();

            $updatedProduct = new AllProduct();
            if ($updatedProduct->update()) {
                $this->redirectToRoute('/updateProduct?id=' . $id);
                exit;
            }
        }

        require_once(__DIR__ . '/../Views/admin.product.edit.view.php');
    }
    // Supprimer un produit (Delete)
    public function deleteProduct($id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
            $this->redirectToRoute('/delete');
            exit;
        }

        $product = new AllProduct();
        if ($product->delete($id)) {
            $this->redirectToRoute('/delete');
            exit;
        }

        $this->redirectToRoute('/delete');
        exit;
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
