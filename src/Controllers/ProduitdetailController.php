<?php

namespace App\Controllers;

use App\Models\AllProduct;
use App\Models\Product;

class ProduitdetailController
{
    public function produitdetail()
    {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

        if (!$id) {
            die("Erreur : ID du produit invalide.");
        }

        $produit = AllProduct::getById($id);

        if (!$produit) {
            die("Erreur : produit introuvable.");
        }

        // Si un avis est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'], $_POST['rating'], $_POST['product_id'])) {
            $comment = htmlspecialchars($_POST['comment']);
            $rating = intval($_POST['rating']);
            $userId = $_SESSION['user']['id'] ?? null;
            $productId = intval($_POST['product_id']); // ✅ très important !

            // Sécurité : vérifier que les données sont valides
            if (!$comment || $rating < 1 || $rating > 5 || !$userId || !$productId) {
                echo "Erreur : Paramètres invalides pour l'ajout d'un avis.";
                return;
            }

            try {
                $created_at = date('Y-m-d H:i:s');
                AllProduct::createReviews($comment, $rating, $created_at, $userId, $productId);
                echo "✅ Avis ajouté avec succès.";
            } catch (\Exception $e) {
                echo "❌ Erreur : " . $e->getMessage();
            }
        }
        $reviews = \App\Models\AllProduct::getReviewsByProductId($id);

        // Charger la vue
        require_once(__DIR__ . "/../Views/produitdetail.view.php");
    }
}

