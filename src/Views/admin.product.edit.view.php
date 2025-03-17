<?php
require_once(__DIR__ . '/../Views/partials/head.php');
?>

<h1>Modification d'un article</h1>
<form method="POST" action="/editProduct?id=<?= htmlspecialchars($product->getId()); ?>" enctype="multipart/form-data">
    <div class="col-md-4 mx-auto d-block mt-5">
        <input type="hidden" name="id" value="<?= htmlspecialchars($product->getId()); ?>">

        <div class="mb-3">
            <label for="name">Nom de l'article</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product->getName()); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" required><?= htmlspecialchars($product->getDescription()); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="price">Prix (€)</label>
            <input type="number" name="price" value="<?= htmlspecialchars($product->getPrice()); ?>" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="stock">Stock</label>
            <input type="number" name="stock" value="<?= htmlspecialchars($product->getStock()); ?>" required>
        </div>

        <div class="mb-3">
            <label for="category">Catégorie</label>
            <input type="text" name="category" value="<?= htmlspecialchars($product->getCategory()); ?>" required>
        </div>

        <div class="mb-3">
            <label for="image">Image actuelle :</label>
            <br>
            <?php if (!empty($product->getImage())): ?>
                <img src="/public/uploads/ <?= htmlspecialchars($product->getImage()); ?>" alt="Image du produit" style="width: 150px;">
            <?php else: ?>
                <p>Aucune image disponible</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="image">Changer l'image</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </div>
</form>

<?php
require_once(__DIR__ . '/../Views/partials/footer.php');
?>
