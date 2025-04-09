<?php

namespace App\Controllers;

use App\Models\AllProduct;
use \PDO;

class ProductController
{
    public function product()
    {
        $productModel = new AllProduct();
        $products = $productModel->getAll();

        $categories = $_GET['category'] ?? [];
        $flavors = $_GET['flavor'] ?? [];
        $maxPrice = $_GET['max_price'] ?? null;

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $products = AllProduct::searchByNameOrCategory($search);
        } else {
            $products = AllProduct::getAll();
        }

        $filteredProducts = array_filter($products, function ($product) use ($categories, $flavors, $maxPrice) {
            $matchesCategory = empty($categories) || in_array(
                strtolower(trim($product->getCategory())),
                array_map(fn($cat) => strtolower(trim($cat)), $categories)
            );

            $matchesFlavor = empty($flavors) || array_intersect(
                array_map('strtolower', $flavors),
                array_map('strtolower', $product->getFlavors())
            );
            $matchesPrice = is_null($maxPrice) || $product->getPrice() <= $maxPrice;


            return $matchesCategory && $matchesFlavor && $matchesPrice;
        });



        require_once(__DIR__ . '/../Views/product.view.php');
    }

    public function updateReviews()
    {
        // Exemple de traitement — à adapter selon ta logique

        $userId = $_SESSION['user']['id'] ?? null;
        $reviewId = $_POST['review_id'] ?? null;
        $newContent = $_POST['comment'] ?? '';
        $newRating = $_POST['rating'] ?? null;

        if (!$userId || !$reviewId || !$newContent || !$newRating) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => "❌ Informations incomplètes pour mettre à jour l'avis."
            ];
            header("Location: /product?id=" . $_POST['product_id']);
            exit;
        }


        // Exemple : je vérifie que l'utilisateur est bien l'auteur
        $review = \App\Models\AllProduct::getReviewById($reviewId);
        
        $review = \App\Models\AllProduct::getReviewById($reviewId);

        
        if ($review && $review['user_id'] == $userId) {
            \App\Models\AllProduct::updateReviews($reviewId, $newContent, $newRating);
        

            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => "✅ Avis mis à jour avec succès !"
            ];
        } else {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => "❌ Vous ne pouvez pas modifier cet avis."
            ];
        }

        header("Location: /product?id=" . $_POST['product_id']);

        exit;
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

        $produit = \App\Models\AllProduct::getById($product_id);
        $reviews = \App\Models\AllProduct::getReviewsByProductId($product_id);

        // ✅ Vérifier si l'utilisateur a déjà laissé un avis
        $hasAlreadyReviewed = false;
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $existingReview = \App\Models\AllProduct::getReviewByUserAndProduct($userId, $product_id);
            $hasAlreadyReviewed = $existingReview ? true : false;
        }

        $reviewModel = new AllProduct(); // ou ReviewModel si tu as un modèle à part
        $hasAlreadyReviewed = $reviewModel->userHasReviewed($userId, $product_id);

        $hasAlreadyReviewed = false;
        if (isset($_SESSION['user'])) {
            $hasAlreadyReviewed = \App\Models\AllProduct::userHasReviewed($_SESSION['user']['id'], $product_id);
        }

        // ✅ Passer toutes les données nécessaires à la vue
        require_once(__DIR__ . '/../Views/produitdetail.view.php');
    }


    public function deleteReviews()
{
    session_start();
    $userId = $_SESSION['user']['id'] ?? null;
    $userRole = $_SESSION['user']['role'] ?? null;

    $reviewId = $_GET['id'] ?? null;
    $productId = $_GET['product_id'] ?? null;

    $review = \App\Models\AllProduct::getReviewById($reviewId);

    if ($review && ($review['user_id'] == $userId || $userRole === 'admin')) {
        \App\Models\AllProduct::deleteReviews($reviewId);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => '✅ Avis supprimé avec succès.'
        ];
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => "❌ Vous n'avez pas le droit de supprimer cet avis."
        ];
    }

    header("Location: /product?id=$productId");
    exit;
}



    public function showProducts()
    {
        $search = $_GET['search'] ?? null;

        if ($search) {
            $products = AllProduct::search($search);
        } else {
            $products = AllProduct::getAll();
        }

        require_once(__DIR__ . '/../Views/products.view.php');
    }


    public static function getAllFiltered($searchTerm = '')
    {
        $pdo = \Config\Database::getInstance()->getConnection();

        if (!empty($searchTerm)) {
            $sql = "SELECT * FROM product WHERE name LIKE :search";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['search' => '%' . $searchTerm . '%']);
        } else {
            $sql = "SELECT * FROM product";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }

        $products = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new self(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'],
                $row['image'],
                $row['stock'],
                $row['category'],
                $row['flavor']
            );
        }

        return $products;
    }
}
