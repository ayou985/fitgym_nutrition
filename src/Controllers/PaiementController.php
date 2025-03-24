<?php

namespace App\Controllers;

class PaiementController {

    public function showPaiement() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $cart = $_SESSION['cart'] ?? [];

        require_once(__DIR__ . "/../Views/paiement.view.php");
    }

    public function processPaiement() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // On peut simuler un traitement ici
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Simuler un "paiement"
            $_SESSION['cart'] = []; // Vider le panier

            // Message ou redirection
            $_SESSION['success'] = "Merci pour votre commande ! Paiement simulé avec succès.";
            header("Location: /paiement");
            exit();
        }

        header("Location: /paiement");
        exit();
    }
}
