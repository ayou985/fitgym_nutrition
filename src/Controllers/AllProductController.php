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

            // Récupération et sécurisation des données
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);
            $category = htmlspecialchars($_POST['category'] ?? '');
            $image = htmlspecialchars($_FILES['image']['tpm'] ?? null);
            
            // Création du produit
            $product = new AllProduct(null, $name, $description, $price, $stock, $category, $image);
            
            if ($product->edit()) {
                $_SESSION['success'] = "Produit ajouté avec succès.";
                $this->redirectToRoute('/products');
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout du produit.";
                $this->redirectToRoute('/products');
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
            $image = null; // Par défaut, l'image est null

            if (!empty($_FILES['image']['name'])) {
                $imageName = basename($_FILES['image']['name']);
                $targetDir = __DIR__ . '/../../public/uploads/';
                $targetFilePath = $targetDir . $imageName;
            
                // Déplacer l'image si elle est téléchargée
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $image = "/uploads/" . $imageName;
                }
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
        }

        require_once(__DIR__ . '/../Views/admin.product.edit.view.php');
    }

    public function deleteProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $product = AllProduct::getById($id);
            
            if ($product && $product->delete()) {
                $_SESSION['success'] = "Produit supprimé avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression.";
            }
        }
        $this->redirectToRoute('/products');
    }
}
