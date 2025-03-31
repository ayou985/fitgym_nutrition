<?php 
require_once(__DIR__ . "/../Views/partials/head.php"); 
?>

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
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $id => $item) : ?>
                        <tr>
                            <td class="cart-product">
                                <img src="/public/uploads/<?= htmlspecialchars($item['product']->getImage()) ?>" alt="<?= htmlspecialchars($item['product']->getName()) ?>">
                                <?= htmlspecialchars($item['product']->getName()) ?>
                            </td>
                            <td><?= number_format($item['product']->getPrice(), 2, ',', ' ') ?> €</td>
                            <td>
                                <input type="number" name="quantities[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="1">
                            </td>
                            <td><?= number_format($item['product']->getPrice() * $item['quantity'], 2, ',', ' ') ?> €</td>
                            <td>
                                <a href="/cart/remove?id=<?= $id ?>" class="btn-remove" onclick="return confirm('Supprimer ce produit du panier ?')">🗑</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="cart-total">Total : <strong><?= number_format($total, 2, ',', ' ') ?> €</strong></p>
            <button type="submit" class="btn-update">Mettre à jour</button>
        </form>
        
        <a href="/paiement" class="btn btn-link">Passer la commande</a>
    <?php else : ?>
        <p class="cart-empty">Votre panier est vide.</p>
    <?php endif; ?>
</div>

<?php 
require_once(__DIR__ . "/../Views/partials/footer.php"); 
?>
