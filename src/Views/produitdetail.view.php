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
            <p class="product-category">Catégorie : <?= htmlspecialchars($produit->getCategory() ?? 'Non classé') ?></p>
            <p class="product-stock">Stock : <?= htmlspecialchars($produit->getStock() ?? 0) ?> unités disponibles</p>
            <p class="product-description"><?= nl2br(htmlspecialchars($produit->getDescription() ?? 'Description non disponible')) ?></p>
            <p class="product-price"><?= number_format($produit->getPrice() ?? 0.00, 2, ',', ' ') ?> €</p>

            <label for="quantity">Quantité :</label>
            <div class="quantity-control">
                <button onclick="decreaseQuantity()">-</button>
                <input type="number" id="quantity" value="1" min="1" max="<?= $produit->getStock() ?? 1 ?>">
                <button onclick="increaseQuantity()">+</button>
            </div>

            <button class="btn-add-cart">Ajouter au panier</button>
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



<script>
    function decreaseQuantity() {
        let qty = document.getElementById("quantity");
        if (qty.value > 1) qty.value--;
    }

    function increaseQuantity() {
        let qty = document.getElementById("quantity");
        if (qty.value < <?= $produit->getStock() ?? 1 ?>) qty.value++;
    }
</script>

<?php
require_once(__DIR__ . "/partials/footer.php");
?>