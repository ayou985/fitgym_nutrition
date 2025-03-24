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

        // Exemple de filtres (vous pouvez les adapter selon vos besoins)
        $categories = $_GET['categories'] ?? []; // Récupère les catégories depuis les paramètres GET
        $flavors = $_GET['flavors'] ?? [];       // Récupère les saveurs depuis les paramètres GET
        $maxPrice = $_GET['maxPrice'] ?? null;   // Récupère le prix maximum depuis les paramètres GET

        if (!empty($categories) || !empty($flavors) || $maxPrice !== null) {
            $filteredProducts = array_filter($products, function ($product) use ($categories, $flavors, $maxPrice) {
                $matchCategory = empty($categories) || in_array(strtolower($product->getCategory()), array_map('strtolower', $categories));
                $matchFlavor = empty($flavors) || in_array(strtolower($product->getDescription()), array_map('strtolower', $flavors));
                $matchPrice = $maxPrice === null || $product->getPrice() <= $maxPrice;
                return $matchCategory && $matchFlavor && $matchPrice;
            });
        } else {
            $filteredProducts = $products;
        }

        // Inclure la vue pour afficher les produits
        require_once(__DIR__ . '/../Views/product.view.php');
    }
}
