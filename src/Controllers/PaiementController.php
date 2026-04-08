<?php

namespace App\Controllers;

class PaiementController
{
    public function debugCart()
    {
        echo '<pre>';
        print_r($_SESSION['cart']);
        echo '</pre>';
    }

    public function showPaiement() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    
        $cart = $_SESSION['cart'] ?? [];
    
        require_once(__DIR__ . "/../Views/paiement.view.php");
    }

    public function processPaiement() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name    = htmlspecialchars($_POST['name'] ?? '');
            $address = htmlspecialchars($_POST['address'] ?? '');
            // Le numéro de carte n'est jamais stocké ni affiché

            // Simuler le traitement du paiement
            $_SESSION['success'] = "Paiement réussi pour $name. Adresse de livraison : $address.";
    
            // Vider le panier après le paiement
            unset($_SESSION['cart']);
    
            header('Location: ' . \App\Utils\AbstractController::getBaseUrl() . '/paiement');
            exit;
        }

    }
}
