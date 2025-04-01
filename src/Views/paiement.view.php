<?php
require_once(__DIR__ . "/partials/head.php");

use App\Controllers\CartController;

// Récupération des articles et du total depuis CartController
$cartData = CartController::getCartItems();
$cartItems = $cartData['items'];
$total = $cartData['total'];
?>

<div class="container mt-5">
    <h2>Paiement</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($cartItems)): ?>


        <p class="mt-3">Total à payer :
            <strong><?= number_format($total, 2, ',', ' ') ?> €</strong>
        </p>

        <hr>
        <h5>Formulaire de paiement</h5>
        <form action="/paiement/process" method="POST">
            <div class="mb-3">
                <label for="name">Nom complet</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="card">Numéro de carte</label>
                <input type="text" name="card" class="form-control" maxlength="16" required>
            </div>

            <div class="mb-3">
                <label for="address">Adresse de livraison</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Valider le paiement</button>
        </form>
    <?php else: ?>
        <p class="text-muted">Votre panier est vide.</p>
    <?php endif; ?>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>