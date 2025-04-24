<?php

namespace App\Controllers;

use App\Models\AllProduct;


class ReviewController
{
    public function delete()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $reviewId = $_GET['id'] ?? null;
        $productId = $_GET['product_id'] ?? null;

        if (!$reviewId || !$productId) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => "❌ Paramètres manquants."
            ];
            header("Location: /product?id=$productId");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $isAdmin = ($_SESSION['user']['id_Role'] ?? 0) == 1;

        $review = AllProduct::getReviewById($reviewId);

        if ($review) {
            $isAuthor = $review['user_id'] == $userId;

            if ($isAuthor || $isAdmin) {
                AllProduct::deleteReviews($reviewId);
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "✅ Avis supprimé avec succès."
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "❌ Vous n'avez pas les droits pour supprimer cet avis."
                ];
            }
        } else {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => "❌ Avis introuvable."
            ];
        }

        header("Location: /product?id=$productId");
        exit;
    }
}
