<?php require_once(__DIR__ . "/../Views/partials/head.php"); ?>


<?php if (!empty($_SESSION['flash'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '<?= $_SESSION["flash"]["type"] ?>',
            title: '<?= $_SESSION["flash"]["type"] === "success" ? "Succès" : "Erreur" ?>',
            text: '<?= $_SESSION["flash"]["message"] ?>',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>



<h1 class="cart-title">Mon Panier</h1>

<div class="cart-container">
    <?php if (!empty($cartItems)) : ?>
        <form action="/cart/update" method="POST">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Stock</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hasStockError = false; // on vérifie à la fin
                    foreach ($cartItems as $id => $item) :
                        $product = $item['product'];
                        $quantity = $item['quantity'];
                        $stock = $product->getStock();
                        $isOverStock = $quantity > $stock;
                        if ($isOverStock) $hasStockError = true;
                    ?>
                        <tr>
                            <td class="cart-product">
                                <img src="/public/uploads/<?= htmlspecialchars($product->getImage()) ?>" alt="<?= htmlspecialchars($product->getName()) ?>">
                                <?= htmlspecialchars($product->getName()) ?>
                            </td>
                            <td><?= number_format($product->getPrice(), 2, ',', ' ') ?> €</td>
                            <td>
                                <input type="number" name="quantities[<?= $id ?>]"
                                    value="<?= $quantity ?>"
                                    min="1"
                                    max="<?= $stock ?>"
                                    style="<?= $isOverStock ? 'border: 1px solid red;' : '' ?>">
                                <?php if ($isOverStock): ?>
                                    <p style="color: red;">❌ Stock max disponible : <?= $stock ?></p>
                                <?php endif; ?>
                            </td>
                            <td><?= $stock ?></td>
                            <td><?= number_format($product->getPrice() * $quantity, 2, ',', ' ') ?> €</td>
                            <td>
                                <a href="/cart/remove?id=<?= $id ?>" class="btn-remove" onclick="return confirm('Supprimer ce produit du panier ?')">🗑</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="cart-total">Total : <strong><?= number_format($total, 2, ',', ' ') ?> €</strong></p>

            <?php if ($hasStockError): ?>
                <p style="color: red;">⚠️ La quantité demandée dépasse le stock disponible pour certains produits.</p>
                <button class="btn btn-link" disabled style="background-color: #ccc;">Passer la commande</button>
            <?php else: ?>
                <a href="/paiement" class="btn btn-link">Passer la commande</a>
            <?php endif; ?>
        </form>
    <?php else : ?>
        <p class="cart-empty">Votre panier est vide.</p>
    <?php endif; ?>
</div>

<?php require_once(__DIR__ . "/../Views/partials/footer.php"); ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const quantityInputs = document.querySelectorAll('input[type="number"][name^="quantities"]');

        quantityInputs.forEach(input => {
            const max = parseInt(input.getAttribute('max'));
            const originalValue = parseInt(input.value);

            input.addEventListener("change", function () {
                let val = parseInt(this.value);

                // Si valeur inférieure à 1
                if (val < 1 || isNaN(val)) {
                    this.value = 1;
                }

                // Si valeur > stock max
                if (val > max) {
                    this.style.border = "1px solid red";
                    alert("⚠️ Quantité dépassant le stock disponible : max " + max + ".");
                    this.value = max;
                } else {
                    this.style.border = "1px solid #ccc";
                }
            });
        });
    });
</script>
