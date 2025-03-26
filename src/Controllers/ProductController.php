<?php
namespace App\Controllers;




use App\Models\AllProduct;


class ProductController
{
    public function product()
    {
        // Création de l'instance du modèle AllProduct
        $productModel = new AllProduct();

        // Récupération des produits
        $products = $productModel->getAll();

        // Récupération des filtres depuis les paramètres GET
        $categories = $_GET['category'] ?? []; // Récupère les catégories sélectionnées
        $flavors = $_GET['flavor'] ?? [];      // Récupère les saveurs sélectionnées
        $maxPrice = $_GET['max_price'] ?? null; // Récupère le prix maximum sélectionné

        // Filtrage des produits
        $filteredProducts = array_filter($products, function ($product) use ($categories, $flavors, $maxPrice) {
            $matchesCategory = empty($categories) || in_array($product->getCategory(), $categories);
            $matchesFlavor = empty($flavors) || array_intersect($flavors, $product->getFlavors());
            $matchesPrice = is_null($maxPrice) || $product->getPrice() <= $maxPrice;

            return $matchesCategory && $matchesFlavor && $matchesPrice;
        });

        // Inclure la vue pour afficher les produits
        require_once(__DIR__ . '/../Views/product.view.php');
    }

    public function submitReview()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: /login");
        exit();
    }

    $userId = $_SESSION['user']['id'];
    $productId = $_POST['product_id'] ?? null;
    $comment = $_POST['comment'] ?? '';
    $rating = (int) ($_POST['rating'] ?? 0);

    // Sécurité : un seul avis par utilisateur et par produit
    $existing = \App\Models\AllProduct::userHasReviewed($userId, $productId);

    if ($existing) {
        header("Location: /product?id=$productId");
        exit();
    }

    if ($comment && $rating >= 1 && $rating <= 5 && $productId) {
        \App\Models\AllProduct::createReview($comment, $rating, $userId, $productId);
    }

    header("Location: /product?id=$productId");
    exit();
}

public function show()
{
    $productId = $_GET['id'] ?? null;

    if (!$productId) {
        header("Location: /products");
        exit();
    }

    $productModel = new AllProduct();
    $product = $productModel->getById($productId); // méthode existante dans ton modèle j’imagine
    $reviews = $productModel::getReviewsByProductId($productId);
    $reviews = AllProduct::getReviewsByProductId($productId);

    // Affiche la vue du produit
    require_once(__DIR__ . '/../Views/product.show.view.php');
}

}
