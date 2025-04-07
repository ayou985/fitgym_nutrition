<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\AllProduct;

class AllProductController extends AbstractController
{
    

    // ✅ Affiche la page de création de produit + traitement
    public function createProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);
            $category = htmlspecialchars($_POST['category'] ?? '');
            $img = null;

            // Traitement de l'image
            if (!empty($_FILES['image']['name'])) {
                $target_dir = "public/uploads/";
                $imgName = basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $imgName;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $img = $imgName;
                }
            }

            // Création du produit
            $product = new AllProduct(null, $name, $description, $price, $stock, $category, $img);
            $product->createProduct();

            $this->redirectToRoute('/products');
        }

        require_once(__DIR__ . '/../Views/admin.product.create.view.php');
    }

    // ✅ Modifier un produit existant
    public function editProduct()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) $this->redirectToRoute('/products');

        $product = AllProduct::getById(intval($id));
        if (!$product) $this->redirectToRoute('/products');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);
            $category = htmlspecialchars($_POST['category'] ?? '');
            $image = $product->getImage();

            if (!empty($_FILES['image']['name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $imageType = $_FILES['image']['type'];
                $imageName = basename($_FILES['image']['name']);
                $targetDir = "public/uploads/";
                $targetPath = $targetDir . $imageName;

                if (in_array($imageType, $allowedTypes) && move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $image = $imageName;
                }
            }

            // Mise à jour du produit
            $product->setName($name);
            $product->setDescription($description);
            $product->setPrice($price);
            $product->setStock($stock);
            $product->setCategory($category);
            $product->setImage($image);

            if ($product->edit()) {
                $_SESSION['success'] = "Produit mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour.";
            }

            $this->redirectToRoute('/products');
        }

        require_once(__DIR__ . '/../Views/admin.product.edit.view.php');
    }

    // ✅ Supprimer un produit
    public function deleteProduct()
    {
        if (isset($_GET['id'])) {
            $product = new AllProduct(intval($_GET['id']));
            $product->delete();
        }

        $this->redirectToRoute('/products');
    }

    public static function getReviewByUserAndProduct($userId, $productId)
    {
        $pdo = \Config\Database::getInstance()->getConnection();
        $sql = "SELECT * FROM reviews WHERE user_id = :user_id AND product_id = :product_id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}
