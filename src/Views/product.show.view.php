<h3 class="mt-5 mb-4">🗣️ Avis des clients</h3>

<?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $review): ?>
        <div class="card mb-4 border-0 shadow-sm rounded-3 review-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0 fw-bold text-primary">
                        <?= htmlspecialchars($review['firstName']) ?> <?= strtoupper(substr($review['lastName'], 0, 1)) ?>.
                    </h5>
                    <small class="text-muted fst-italic">
                        Posté le <?= date('d/m/Y', strtotime($review['created_at'])) ?>
                    </small>
                </div>

                <div class="mb-2">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa<?= $i <= $review['rating'] ? 's' : 'r' ?> fa-star text-warning"></i>
                    <?php endfor; ?>
                    <span class="ms-1 text-muted">(<?= $review['rating'] ?>/5)</span>
                </div>

                <p class="card-text fst-italic"><?= htmlspecialchars($review['comment']) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-secondary">Aucun avis pour ce produit. Soyez le premier à en laisser un ! 😄</div>
<?php endif; ?>
