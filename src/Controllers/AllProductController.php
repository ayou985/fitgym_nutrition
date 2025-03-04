<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\AllProduct;

class AllProductController extends AbstractController
{
    public function index()
    {
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            $idProduct = intval($_GET['id']);
            $product = AllProduct::getById($idProduct);

            if (!$product) {
                $this->redirectToRoute('/admin/products');
            }

            require_once(__DIR__ . '/../Views/admin/product.view.php');
        } else {
            $this->redirectToRoute('/create');
        }
    }

    public function createProduct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
            $this->redirectToRoute('/admin/products');
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['price']);
            $stock = intval($_POST['stock']);
            $category = htmlspecialchars($_POST['category']);
            
            // Gestion des fichiers uploadés
            $image = null;
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
                $targetDir = __DIR__ . "/../../public/uploads/";
                $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array(strtolower($fileType), $allowedTypes)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $image = $fileName;
                    }
                }
            }

            $product = new AllProduct(null, $name, $description, $price, $stock, $category, $image);
            if ($product->save()) {
                $this->redirectToRoute('/admin/products');
            }
        }

        require_once(__DIR__ . '/../Views/admin.product.create.view.php');
    }

    public function deleteProduct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
            $this->redirectToRoute('/admin/products');
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id']) && ctype_digit($_POST['id'])) {
            $idProduct = intval($_POST['id']);
            if (AllProduct::delete($idProduct)) {
                $this->redirectToRoute('/admin/products');
            }
        }

        $this->redirectToRoute('/admin/products');
    }

    // 🆕 Lire un produit (Read)
    public function readProduct()
    {
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            $this->redirectToRoute('/admin/products');
            return;
        }

        $idProduct = intval($_GET['id']);
        $product = AllProduct::getById($idProduct);

        var_dump($product);
        exit;

        if (!$product) {
            $this->redirectToRoute('/admin/products');
            return;
        }

        require_once(__DIR__ . '/../Views/admin/product.show.view.php');
    }

    // 🆕 Modifier un produit (Update)
    public function updateProduct()
    {
        {
            var_dump($_GET); 
            exit;
        }
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
            $this->redirectToRoute('/admin/products');
            return;
        }

        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            $this->redirectToRoute('/admin/products');
            return;
        }

        $idProduct = intval($_GET['id']);
        $product = AllProduct::getById($idProduct);

        if (!$product) {
            $this->redirectToRoute('/admin/products');
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['price']);
            $stock = intval($_POST['stock']);
            $category = htmlspecialchars($_POST['category']);

            // Gestion des fichiers uploadés
            $image = $product['image']; // Garde l'ancienne image par défaut
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
                $targetDir = __DIR__ . "/../../public/uploads/";
                $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array(strtolower($fileType), $allowedTypes)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $image = $fileName;
                    }
                }
            }

            $updatedProduct = new AllProduct($idProduct, $name, $description, $price, $stock, $category, $image);
            if ($updatedProduct->update()) {
                $this->redirectToRoute('/admin/products');
            }
        }

        require_once(__DIR__ . '/../Views/admin.product.edit.view.php');
    }
}
