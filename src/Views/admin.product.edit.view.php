<?php
require_once(__DIR__ . '/../Views/partials/head.php');
?>

<h1>Modification d'un article</h1>
<form method="POST" action="/updateProduct?id=<?= htmlspecialchars($product['id']); ?>" enctype="multipart/form-data">
    <div class="col-md-4 mx-auto d-block mt-5">
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">

        <div class="mb-3">
            <label for="name">Nom de l'article</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" required><?= htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="price">Prix (€)</label>
            <input type="number" name="price" value="<?= htmlspecialchars($product['price']); ?>" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="stock">Stock</label>
            <input type="number" name="stock" value="<?= htmlspecialchars($product['stock']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="category">Catégorie</label>
            <input type="text" name="category" value="<?= htmlspecialchars($product['category']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="image">Image actuelle :</label>
            <br>
            <img src="<?= htmlspecialchars($product['image']); ?>" alt="Image du produit" style="width: 150px;">
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
