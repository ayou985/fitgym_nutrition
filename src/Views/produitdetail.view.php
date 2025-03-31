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
            <p class="product-description"><?= nl2br(html_entity_decode($produit->getDescription() ?? 'Description non disponible')) ?></p>
            <p class="product-price"><strong>Prix :</strong> <?= number_format($produit->getPrice() ?? 0.00, 2, ',', ' ') ?> €</p>

            <?php if (isset($_SESSION['user'])): ?>
                <form action="/cart/add" method="POST">
                    <input type="hidden" name="id" value="<?= $produit->getId() ?>">

                    <label for="quantity"><strong>Quantité :</strong></label>
                    <div class="quantity-control">
                        <button type="button" onclick="changeQuantity(-1)">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $produit->getStock() ?>">
                        <button type="button" onclick="changeQuantity(1)">+</button>
                    </div>

                    <button type="submit" class="btn-add-cart">🛒 Ajouter au panier</button>
                </form>
            <?php else: ?>
                <div class="not-logged-message">
                    <p>🔒 Connectez-vous pour ajouter ce produit au panier.</p>
                    <a href="/login" class="btn">Se connecter</a>
                </div>
            <?php endif; ?>

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
<hr>
<h2>Avis des clients</h2>

<?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $review): ?>
        <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">
            <strong><?= htmlspecialchars($review['firstname'] . ' ' . strtoupper(substr($review['lastname'], 0, 1))) ?>.</strong><br>
            <span>Note : <?= str_repeat('⭐', $review['rating']) ?> (<?= $review['rating'] ?>/5)</span><br>
            <p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
            <small>Posté le <?= date('d/m/Y', strtotime($review['created_at'])) ?></small>

            <!-- ✅ Ajoute ceci dans la boucle pour afficher les boutons si user est l'auteur -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $review['user_id']): ?>
                <hr>
                <!-- ✏️ Formulaire de modification -->
                <form action="/updateReviews" method="POST">
                    <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                    <input type="hidden" name="product_id" value="<?= $produit->getId() ?>">

                    <label>Modifier :</label><br>
                    <textarea name="comment" rows="2" cols="50"><?= htmlspecialchars($review['comment']) ?></textarea><br>

                    <label>Note :</label>
                    <select name="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>" <?= $i == $review['rating'] ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <button type="submit">✅ Sauvegarder</button>
                </form>

                <!-- 🗑️ Bouton de suppression -->
                <br>
                <a href="/deleteReviews?id=<?= $review['id'] ?>&product_id=<?= $produit->getId() ?>"
                    onclick="return confirm('Supprimer cet avis ?')">🗑️ Supprimer</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

<?php else: ?>
    <p>Aucun avis pour ce produit. Soyez le premier à en laisser un !</p>
<?php endif; ?>

<?php if (isset($_SESSION['user'])): ?>
    <hr>
    <h3>Laisser un avis</h3>
    <form method="POST">
        <input type="hidden" name="product_id" value="<?= $produit->getId() ?>">

        <label for="rating">Note (1 à 5) :</label>
        <select name="rating" id="rating" required>
            <option value="">Choisir une note</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>

        <br><br>

        <label for="comment">Commentaire :</label><br>
        <textarea name="comment" id="comment" rows="4" cols="50" required></textarea>

        <br><br>
        <button type="submit">Envoyer</button>
    </form>
<?php else: ?>
    <p><a href="/login">Connectez-vous</a> pour laisser un avis.</p>
<?php endif; ?>

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