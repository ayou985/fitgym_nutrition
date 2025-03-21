<?php
require_once(__DIR__ . "/partials/head.php");
?>

<div class="container product-details">
    <div class="row">
        <!-- Image du produit -->
        <div class="col-md-6">
            <img src="/public/uploads/<?= htmlspecialchars($produit->getImage() ?? 'default.jpg') ?>" 
                class="img-fluid product-image"
                alt="<?= htmlspecialchars($produit->getName() ?? 'Nom inconnu') ?>">
        </div>

        <!-- Infos du produit -->
        <div class="col-md-6">
            <h1><?= htmlspecialchars($produit->getName() ?? 'Nom inconnu') ?></h1>
            <p class="product-category"><strong>Catégorie :</strong> <?= htmlspecialchars($produit->getCategory() ?? 'Non classé') ?></p>
            <p class="product-stock"><strong>Stock :</strong> <?= htmlspecialchars($produit->getStock() ?? 0) ?> unités disponibles</p>
            <p class="product-description"><?= nl2br(htmlspecialchars($produit->getDescription() ?? 'Description non disponible')) ?></p>
            <p class="product-price"><strong>Prix :</strong> <?= number_format($produit->getPrice() ?? 0.00, 2, ',', ' ') ?> €</p>

            <!-- Formulaire d'ajout au panier -->
            <form action="/cart/add" method="POST">
                <input type="hidden" name="id" value="<?= $produit->getId() ?>">

                <label for="quantity"><strong>Quantité :</strong></label>
                <div class="quantity-control">
                    <button type="button" onclick="changeQuantity(-1)">-</button>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $produit->getStock() ?? 1 ?>">
                    <button type="button" onclick="changeQuantity(1)">+</button>
                </div>

                <button type="submit" class="btn-add-cart">🛒 Ajouter au panier</button>
            </form>
        </div>
    </div>

    <!-- Section Caractéristiques du produit -->
    <div class="product-description-section">
        <h3>Description détaillée</h3>
        <ul>
            <li>Qualité premium</li>
            <li>Riche en protéines</li>
            <li>Parfait pour la récupération musculaire</li>
            <li>Disponible en plusieurs saveurs</li>
        </ul>

        <h3>Caractéristiques</h3>
        <table class="table">
            <tr>
                <th>Prix</th>
                <td><?= number_format($produit->getPrice() ?? 0.00, 2, ',', ' ') ?> €</td>
            </tr>
            <tr>
                <th>Stock</th>
                <td><?= $produit->getStock() ?? 0 ?> unités disponibles</td>
            </tr>
            <tr>
                <th>Catégorie</th>
                <td><?= htmlspecialchars($produit->getCategory() ?? 'Non classé') ?></td>
            </tr>
        </table>
    </div>
</div>

<!-- Script JS pour gérer la quantité -->
<script>
    function changeQuantity(amount) {
        let qtyInput = document.getElementById("quantity");
        let newValue = parseInt(qtyInput.value) + amount;
        if (newValue >= 1 && newValue <= <?= $produit->getStock() ?? 1 ?>) {
            qtyInput.value = newValue;
        }
    }
</script>

<?php
require_once(__DIR__ . "/partials/footer.php");
?>
