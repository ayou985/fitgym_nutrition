<?php

namespace App\Controllers;

use App\Models\AllProduct;

class CartController {
    public function showCart() {
        
        
        // Vérifier si le panier existe
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Récupérer les produits du panier
        $cartItems = [];
        $total = 0;

        foreach ($_SESSION['cart'] as $id => $quantity) {
            $product = AllProduct::getById($id);
            if ($product) {
                $cartItems[$id] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
                $total += $product->getPrice() * $quantity;
            }
        }

        // Charger la vue avec les données du panier
        require_once(__DIR__ . "/../Views/cart.view.php");
    }

    public function addToCart() {

        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        if ($id) {
            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = 0;
            }
            $_SESSION['cart'][$id] += $quantity;
        }

        header("Location: /cart");
        exit();
    }

    public function removeFromCart() {

        $id = isset($_POST['id']) ? intval($_POST['id']) : null;

        if ($id && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }

        header("Location: /cart");
        exit();
    }

    public function updateCart() {

        foreach ($_POST['quantities'] as $id => $quantity) {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = max(1, intval($quantity));
            }
        }

        header("Location: /cart");
        exit();
    }
}
