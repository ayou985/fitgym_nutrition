<?php

namespace App\Controllers;

use App\Models\AllProduct;

class CartController {
    public function showCart() {
        $cart = $_SESSION['cart'] ?? [];
    
        $cartItems = [];
        $total = 0;
    
        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\AllProduct::getById($productId);
            if ($product) {
                $lineTotal = $product->getPrice() * $quantity;
                $total += $lineTotal;
                $cartItems[$productId] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
    
        require_once(__DIR__ . '/../Views/cart.view.php');
    }
    

    public function addToCart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = $_POST['id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        // Sécurité : Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        // Récupère le produit
        $product = AllProduct::getById($productId);

        // 🟡 AJOUTE CE BLOC ICI 👇
        if ($product && $product->getStock() >= $quantity) {
            $newStock = $product->getStock() - $quantity;
            $product->setStock($newStock)->edit(); // maj BDD
        } else {
            echo 'Stock insuffisant pour ce produit.'; // Ensure proper syntax
            exit;
        }

        // Ajoute au panier (en session ou BDD selon ton code)
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $quantity;

        header('Location: /cart');
        exit;
    }
}

    public function removeFromCart() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            unset($_SESSION['cart'][$id]);
        }

        header("Location: /cart");
        exit();
    }public static function getCartItems()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
    
        $cart = $_SESSION['cart'] ?? [];
        $items = [];
        $total = 0;
    
        foreach ($cart as $productId => $quantity) {
            $product = AllProduct::getById($productId);
            if ($product) {
                $subtotal = $product->getPrice() * $quantity;
                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
                $total += $subtotal;
            }
        }
    
        return ['items' => $items, 'total' => $total];
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

    public function showPaiement() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    
        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $total = 0;
    
        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\AllProduct::getById($productId);
            if ($product) {
                $lineTotal = $product->getPrice() * $quantity;
                $total += $lineTotal;
    
                $product->setQuantity($quantity);
                $cartItems[] = $product;
            }
        }
    
        require_once(__DIR__ . '/../Views/paiement.view.php');
    }
    
}
