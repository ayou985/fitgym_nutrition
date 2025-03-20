<?php

namespace App\Controllers;

use App\Models\AllProduct;

class ProduitdetailController {
    public function produitdetail() {
        // Vérifier que l'ID est bien passé et valide
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

        if (!$id) {
            die("Erreur : ID du produit invalide.");
        }

        // Récupérer le produit
        $produit = AllProduct::getById($id);

        // Vérifier si le produit a été trouvé
        if (!$produit) {
            die("Erreur : produit introuvable.");
        }

        // Charger la vue avec le produit
        require_once(__DIR__ . "/../Views/produitdetail.view.php");
    }
}
