<?php

namespace App\Controllers;

use App\Models\AllProduct;

class ProductController
{
    public function product()
    {
        $productModel = new AllProduct();
        $products = $productModel->getAll();

        $categories = $_GET['category'] ?? [];
        $flavors = $_GET['flavor'] ?? [];
        $maxPrice = $_GET['max_price'] ?? null;

        $filteredProducts = array_filter($products, function ($product) use ($categories, $flavors, $maxPrice) {
            $matchesCategory = empty($categories) || in_array($product->getCategory(), $categories);
            $matchesFlavor = empty($flavors) || array_intersect($flavors, $product->getFlavors());
            $matchesPrice = is_null($maxPrice) || $product->getPrice() <= $maxPrice;

            return $matchesCategory && $matchesFlavor && $matchesPrice;
        });

        require_once(__DIR__ . '/../Views/product.view.php');
    }

    public function submitReviews()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = htmlspecialchars($_POST['comment'] ?? '');
            $rating = intval($_POST['rating'] ?? 0);
            $userId = $_SESSION['user']['id'] ?? null;
            $productId = intval($_POST['product_id'] ?? 0);

            if (empty($comment) || $rating < 1 || $rating > 5 || empty($userId) || empty($productId)) {
                echo "Erreur : Paramètres invalides pour l'ajout d'un avis.";
                return;
            }

            try {
                $created_at = date('Y-m-d H:i:s');
                AllProduct::createReviews($comment, $rating, $created_at, $userId, $productId);

                // ✅ Redirection vers la fiche produit avec l'ID
                header("Location: /produitdetail?id=" . $productId);
                exit;

            } catch (\Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    }

    public function show()
    {
        $product_id = $_GET['id'] ?? null;

        if (!$product_id) {
            echo "Produit introuvable";
            exit;
        }

        $product = \App\Models\AllProduct::getById($product_id);
        $reviews = \App\Models\AllProduct::getReviewsByProductId($product_id);

        require_once(__DIR__ . '/../Views/product.show.view.php');
    }

    public function updateReviews()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reviewId = intval($_POST['review_id'] ?? 0);
            $comment = htmlspecialchars($_POST['comment'] ?? '');
            $rating = intval($_POST['rating'] ?? 0);
            $productId = intval($_POST['product_id'] ?? 0);
    
            if (!$reviewId || !$comment || $rating < 1 || $rating > 5 || !$productId) {
                echo "Données invalides";
                return;
            }
    
            \App\Models\AllProduct::updateReviews($reviewId, $comment, $rating);
            header("Location: /produitdetail?id=" . $productId);
            exit;
        }
    }
    public function deleteReviews()
    {
        if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['product_id'])) {
            $reviewId = intval($_GET['id']);
            $productId = intval($_GET['product_id']);
    
            \App\Models\AllProduct::deleteReviews($reviewId);
    
            header("Location: /produitdetail?id=" . $productId);
            exit;
        } else {
            echo "Paramètres manquants";
        }
    }
    
    
}
