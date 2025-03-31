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
            $name = htmlspecialchars($_POST['name'] ?? '');
            $card = htmlspecialchars($_POST['card'] ?? '');
            $address = htmlspecialchars($_POST['address'] ?? '');
    
            // Simuler le traitement du paiement
            $_SESSION['success'] = "Paiement réussi pour $name. Détails de la carte : $card. Adresse : $address.";
    
            // Vider le panier après le paiement
            unset($_SESSION['cart']);
    
            header('Location: /paiement');
            exit;
        }

    }
}
