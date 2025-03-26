<?php if (isset($_SESSION['user'])): ?>
    <?php if (!$hasAlreadyReviewed): ?>
        <form action="/product/review" method="POST" class="mt-4">
            <input type="hidden" name="product_id" value="<?= $product->getId() ?>">

            <div class="form-group">
                <label for="comment">Votre avis :</label>
                <textarea name="comment" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="rating">Note :</label>
                <select name="rating" class="form-control" required>
                    <option value="5">⭐️⭐️⭐️⭐️⭐️</option>
                    <option value="4">⭐️⭐️⭐️⭐️</option>
                    <option value="3">⭐️⭐️⭐️</option>
                    <option value="2">⭐️⭐️</option>
                    <option value="1">⭐️</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-2">Envoyer mon avis</button>
        </form>
    <?php else: ?>
        <p class="text-info">Vous avez déjà laissé un avis pour ce produit.</p>
    <?php endif; ?>
<?php else: ?>
    <p class="text-muted">Connectez-vous pour laisser un avis.</p>
<?php endif; ?>


<h3 class="mt-5">Avis des utilisateurs :</h3>

<?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $review): ?>
        <div class="border p-3 mb-3">
            <strong><?= htmlspecialchars($review['firstName']) ?> <?= htmlspecialchars($review['lastName']) ?></strong>
            <div>
                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                    ⭐
                <?php endfor; ?>
            </div>
            <p><?= htmlspecialchars($review['comment']) ?></p>
            <small class="text-muted"><?= date('d/m/Y à H:i', strtotime($review['created_at'])) ?></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun avis pour le moment.</p>
<?php endif; ?>
