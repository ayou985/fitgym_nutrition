<?php require_once(__DIR__ . "/partials/head.php"); ?>

<div class="container mt-5">
    <h2>Paiement</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <ul>
        <?php
        $total = 0;
        foreach ($cart as $item):
            if (!is_array($item)) continue; // 🔥 sécurité
            $name = htmlspecialchars($item['name'] ?? 'Nom inconnu');
            $quantity = $item['quantity'] ?? 1;
            $price = $item['price'] ?? 0.00;
            $total += $quantity * $price;
        ?>
            <li><?= $name ?> - <?= $quantity ?> x <?= number_format($price, 2) ?> €</li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total :</strong> <?= number_format($total, 2, ',', ' ') ?> €</p>


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

    <p>Votre panier est vide.</p>

</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>