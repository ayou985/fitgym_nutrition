<?php
require_once(__DIR__ . "/partials/head.php");
?>

<!-- Sécurise l'existence de la variable pour éviter les warnings  -->

<?php $hasAlreadyReviewed = $hasAlreadyReviewed ?? false; ?>
<div class="container product-details">
    <div class="product-layout">
        <!-- Colonne gauche : image -->
        <div class="product-left">
            <img src="<?= $baseUrl ?>/public/uploads/<?= htmlspecialchars($produit->getImage() ?? 'default.jpg') ?>"
                class="img-fluid product-image"
                alt="<?= htmlspecialchars($produit->getName() ?? 'Nom inconnu') ?>">
        </div>

        <!-- Colonne droite : infos -->
        <div class="product-right">
            <h1><?= htmlspecialchars($produit->getName() ?? 'Nom inconnu') ?></h1>
            <p class="product-category"><strong>Catégorie :</strong> <?= htmlspecialchars($produit->getCategory() ?? 'Non classé') ?></p>
            <p class="product-stock"><strong>Stock :</strong> <?= htmlspecialchars($produit->getStock() ?? 0) ?> unités disponibles</p>
            <p class="product-description"><?= nl2br(html_entity_decode($produit->getDescription() ?? 'Description non disponible')) ?></p>
            <p class="product-price"><strong>Prix :</strong> <?= number_format($produit->getPrice() ?? 0.00, 2, ',', ' ') ?> €</p>

            <?php if (isset($_SESSION['user'])): ?>
                <form action="<?= $baseUrl ?>/cart/add" method="POST">
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
                    <a href="<?= $baseUrl ?>/login" class="btn">Se connecter</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <hr>
    <h3 class="mt-5 mb-4">Avis des clients</h3>

    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="card mb-4 shadow-sm border-0 review-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title mb-1">
                            <?= htmlspecialchars($review['username']) ?> <?= strtoupper(substr($review['lastname'], 0, 1)) ?>.
                        </h5>
                        <small class="text-muted"><?= date('d/m/Y', strtotime($review['created_at'])) ?></small>
                    </div>

                    <div class="mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa<?= $i <= $review['rating'] ? 's' : 'r' ?> fa-star text-warning"></i>
                        <?php endfor; ?>
                        <span class="text-muted">(<?= $review['rating'] ?>/5)</span>
                    </div>

                    <p class="card-text"><?= $review['comment'] ?></p>



                    <!-- ✅ BOUTON SUPPRIMER POUR L’ADMIN (TOUS LES AVIS) -->
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id_Role'] == '1'): ?>
                        <a href="<?= $baseUrl ?>/review/delete?id=<?= $review['id'] ?>&product_id=<?= $produit->getId() ?>"
                            onclick="return confirm('Supprimer cet avis ?')"
                            class="btn btn-sm btn-outline-danger ms-2">
                            🗑 Supprimer (admin)
                        </a>


                    <?php endif; ?>


                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $review['user_id']): ?>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $review['user_id']): ?>
                            <form action="<?= $baseUrl ?>/updateReviews" method="POST" class="mt-2">
                                <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                <input type="hidden" name="product_id" value="<?= $produit->getId() ?>">

                                <textarea name="comment" rows="2" class="form-control mb-2"><?= $review['comment'] ?></textarea>

                                <select name="rating" class="form-select mb-2 w-auto d-inline-block">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?= $i ?>" <?= $i == $review['rating'] ? 'selected' : '' ?>><?= $i ?> ⭐</option>
                                    <?php endfor; ?>
                                </select>

                                <button type="submit" class="btn btn-sm btn-success">✅ Sauvegarder</button>

                                <!-- ✅ BOUTON SUPPRIMER POUR L’AUTEUR SEULEMENT -->
                                <a href="<?= $baseUrl ?>/deleteReviews?id=<?= $review['id'] ?>&product_id=<?= $produit->getId() ?>"
                                    onclick="return confirm('Supprimer votre avis ?')"
                                    class="btn btn-sm btn-outline-danger ms-2">
                                    🗑️ Supprimer (vous)
                                </a>
                            </form>
                        <?php endif; ?>


                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">Aucun avis pour ce produit.</p>
    <?php endif; ?>

    <?php if (isset($_SESSION['user']) && !$hasAlreadyReviewed): ?>
        <div class="add-comment-form mt-5">
            <h4>Laisser un avis</h4>
            <form method="POST" action="<?= $baseUrl ?>/submitReviews">
                <input type="hidden" name="product_id" value="<?= $produit->getId() ?>">

                <div class="form-group mt-4">
                    <label for="rating">Note :</label>
                    <select name="rating" id="rating" class="form-select" required>
                        <option value="" disabled selected>Choisir une note</option>
                        <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                        <option value="4">⭐⭐⭐⭐ (4)</option>
                        <option value="3">⭐⭐⭐ (3)</option>
                        <option value="2">⭐⭐ (2)</option>
                        <option value="1">⭐ (1)</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="comment">Commentaire :</label>
                    <textarea name="comment" id="comment" rows="4" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-danger mt-3">Envoyer</button>
            </form>
        </div>
    <?php elseif (isset($_SESSION['user'])): ?>
        <p class="text-info mt-4">Vous avez déjà laissé un avis pour ce produit.</p>
    <?php else: ?>
        <p class="text-muted mt-4">Connectez-vous pour laisser un avis.</p>
    <?php endif; ?>
</div>

<script>
    function changeQuantity(amount) {
        const input = document.getElementById('quantity');
        let newValue = parseInt(input.value) + amount;
        if (newValue >= 1 && newValue <= <?= $produit->getStock() ?>) {
            input.value = newValue;
        }
    }
</script>

<?php if (!empty($_SESSION['flash'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '<?= $_SESSION['flash']['type'] === 'success' ? 'success' : 'error' ?>',
            title: '<?= $_SESSION['flash']['message'] ?>',
            confirmButtonColor: '#d33',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php
require_once(__DIR__ . "/partials/footer.php");
?>

<script>
    function changeQuantity(amount) {
        const qtyInput = document.getElementById("quantity");
        const maxQty = parseInt(qtyInput.max);
        const minQty = parseInt(qtyInput.min);
        let current = parseInt(qtyInput.value);

        const newValue = current + amount;

        if (newValue >= minQty && newValue <= maxQty) {
            qtyInput.value = newValue;
        }
    }

    // Empêche l'utilisateur de taper une valeur supérieure au stock
    document.getElementById("quantity").addEventListener("input", function() {
        const max = parseInt(this.max);
        const min = parseInt(this.min);
        let value = parseInt(this.value);

        if (value > max) {
            this.value = max;
        } else if (value < min || isNaN(value)) {
            this.value = min;
        }
    });
</script>