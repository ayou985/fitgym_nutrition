<?php
require_once(__DIR__ . "/partials/head.php");
?>

<!-- Bannière -->
<div class="banner-container text-center">
    <img src="/public/img/carrousel_produit.png" alt="FitGym Nutrition Banner" class="img-fluid">
</div>

<h1 class="text-center mt-4">Produits</h1>
<p class="text-center">FitGym Nutrition propose des compléments alimentaires pour booster vos performances, favoriser la récupération et atteindre vos objectifs.</p>

<div class="container mt-4">
    <div class="row">
        <!-- Filtres -->
        <aside class="col-md-3">
            <h4>Filtres</h4>
            <h6>Catégorie</h6>
            <ul class="list-unstyled">
                <li><input type="checkbox"> BCAA</li>
                <li><input type="checkbox"> Barres protéinées</li>
                <li><input type="checkbox"> Multivitamines</li>
                <li><input type="checkbox"> Whey isolate</li>
                <li><input type="checkbox"> Zinc & magnésium</li>
            </ul>

            <h6>Saveur</h6>
            <ul class="list-unstyled">
                <li><input type="checkbox"> Chocolat</li>
                <li><input type="checkbox"> Chocolat brownie</li>
                <li><input type="checkbox"> Citron vert</li>
                <li><input type="checkbox"> Vanille</li>
            </ul>

            <h6>Prix</h6>
            <input type="range" min="1" max="150" class="form-range">
        </aside>

        <!-- Produits -->
        <section class="col-md-9">
            <div class="row">
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="/uploads/<?= htmlspecialchars($product->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($product->name) ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product->price) ?> €</p>
                                <a href="/product/<?= $product->id ?>" class="btn btn-primary">Voir le produit</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>

<?php
require_once(__DIR__ . "/partials/footer.php");
?>
