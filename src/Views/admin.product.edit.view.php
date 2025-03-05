<form action="/edit?id=<?= $product->getId(); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $product->getId(); ?>">

    <label>Nom :</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product->getName()); ?>" required>

    <label>Description :</label>
    <textarea name="description"><?= htmlspecialchars($product->getDescription()); ?></textarea>

    <label>Prix :</label>
    <input type="number" name="price" value="<?= $product->getPrice(); ?>" step="0.01" required>

    <label>Stock :</label>
    <input type="number" name="stock" value="<?= $product->getStock(); ?>" required>

    <label>Catégorie :</label>
    <input type="text" name="category" value="<?= htmlspecialchars($product->getCategory()); ?>" required>

    <label>Image :</label>
    <input type="file" name="image">

    <button type="submit">Modifier</button>
</form>
