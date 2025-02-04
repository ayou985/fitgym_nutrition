<?php
namespace Controllers;

class ProductController {
 

    // Affiche la liste des produits
    public function list() {
        echo "Liste des produits";
        // Logique pour afficher tous les produits
    }

    // Affiche la page de détails d'un produit
    public function details($productId) {
        echo "Détails du produit $productId";
        // Logique pour afficher les détails d'un produit spécifique
    }

    // Ajoute un produit au panier (exemple de méthode)
    public function addToCart($productId) {
        echo "Produit $productId ajouté au panier";
        // Logique pour ajouter le produit au panier
    }
   
}
?>
