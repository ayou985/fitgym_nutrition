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
            <form method="GET" action="/products">
                <h6>Catégorie</h6>
                <?php
                $categories = ["BCAA", "Barres protéinées", "Multivitamines", "Whey isolate", "Pre-workout"];
                foreach ($categories as $cat) {
                    $checked = isset($_GET['category']) && in_array($cat, $_GET['category']) ? 'checked' : '';
                    echo "<div><input type='checkbox' name='category[]' value=\"$cat\" $checked> $cat</div>";
                }
                ?>

                <h6 class="mt-3">Saveur</h6>
                <?php
                $flavors = ["Chocolat", "Chocolat brownie", "Citron vert", "Vanille"];
                foreach ($flavors as $flavor) {
                    $checked = isset($_GET['flavor']) && in_array($flavor, $_GET['flavor']) ? 'checked' : '';
                    echo "<div><input type='checkbox' name='flavor[]' value=\"$flavor\" $checked> $flavor</div>";
                }
                ?>

                <h6 class="mt-3">Prix max</h6>
                <input type="range" name="max_price" min="1" max="150" value="<?= $_GET['max_price'] ?? 150 ?>" class="form-range">
                <p>Jusqu'à <?= $_GET['max_price'] ?? 150 ?> €</p>

                <button type="submit" class="btn btn-primary mt-2">Filtrer</button>
            </form>
        </aside>

        <!-- Produits -->
        <section class="col-md-9">
            <div class="row">
                <?php if (!empty($filteredProducts)) : ?>
                    <?php foreach ($filteredProducts as $product) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="/public/uploads/<?= $product->getImage() ?>" class="card-img-top" alt="<?= htmlspecialchars($product->getName()) ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= $product->getName() ?></h5>
                                    <p class="card-text"><?= number_format($product->getPrice(), 2, ',', ' ') ?> €</p>
                                    <a href="/produitdetail?id=<?= $product->getId() ?>" class="btn btn-primary">Voir</a>

                                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id_Role'] == 1) : ?>
                                        <a href="/editProduct?id=<?= $product->getId() ?>" class="btn btn-warning mt-2">Modifier</a>
                                        <a href="/deleteProduct?id=<?= $product->getId() ?>" class="btn btn-danger mt-2"
                                            onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <p class="text-center">Aucun produit ne correspond à vos critères.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>