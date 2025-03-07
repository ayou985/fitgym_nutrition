<?php

namespace App\Controllers;

use App\Models\AllProduct;

class ProductController
{
    public function product()
    {
        // Création de l'instance du modèle AllProduct
        $product = new AllProduct(null, null, null, null, null, null, null);
        
        // Récupération des produits
        $products = $product->getAll();
        
        // Passage des produits à la vue
        require_once(__DIR__ . "/../Views/product.view.php");
    }
}
