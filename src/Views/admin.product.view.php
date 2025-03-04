<?php
require_once(__DIR__ . "/partials/head.php");

// Vérifie si la variable $products est bien définie et contient des produits
if (!isset($products) || !is_array($products)) {
    $products = []; // Évite l'erreur si $products est indéfini
}
?>

<div class="product-container">
    <img src="public/img/carrousel_produit.png" alt="Image produit">
    <h2>Produits</h2>
    <p>FitGym Nutrition propose des compléments alimentaires pour booster vos performances, favoriser la récupération et atteindre vos objectifs.</p>
</div>

<!-- Section de filtres -->
<div class="filters">
    <h3>Filtres</h3>
    <div class="filter-category">
        <h4>Catégorie</h4>
        <ul>
            <li><input type="checkbox"> BCAA</li>
            <li><input type="checkbox"> Barres protéinées</li>
            <li><input type="checkbox"> Multivitamines</li>
            <li><input type="checkbox"> Whey isolate</li>
            <li><input type="checkbox"> Zinc & magnésium</li>
        </ul>
    </div>
    <div class="filter-category">
        <h4>Saveur</h4>
        <ul>
            <li><input type="checkbox"> Chocolat</li>
            <li><input type="checkbox"> Chocolat brownie</li>
            <li><input type="checkbox"> Citron vert</li>
            <li><input type="checkbox"> Vanille</li>
        </ul>
    </div>
    <div class="filter-category">
        <h4>Prix</h4>
        <input type="range" min="1" max="150" value="50">
    </div>
</div>

<!-- Liste des produits -->
<div class="products-list">
    <?php
    var_dump($products);
    if (!empty($products)) {



    ?>
        <?php foreach ($products as $product) {
        ?>
            <div class="product-card">
                <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p class="price"><?= htmlspecialchars($product['price']) ?> €</p>
                <a href="product.php?id=<?= htmlspecialchars($product['id']) ?>" class="btn">Voir le produit</a>
            </div>
        <?php  }  ?>
    <?php  }  ?>
    <p class="no-products">Aucun produit disponible pour le moment.</p>
    <?php   ?>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>