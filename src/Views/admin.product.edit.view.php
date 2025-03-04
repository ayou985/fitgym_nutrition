<form action="/edit?id=<?= htmlspecialchars($product->getId()) ?>" method="POST">
    <label for="name">Nom :</label>
    <input type="text" name="name" id="name" value="<?= htmlspecialchars($product->getName()) ?>" required>

    <label for="description">Description :</label>
    <textarea name="description" id="description"><?= htmlspecialchars($product->getDescription()) ?></textarea>

    <label for="price">Prix :</label>
    <input type="number" step="0.01" name="price" id="price" value="<?= htmlspecialchars($product->getPrice()) ?>" required>

    <label for="stock">Stock :</label>
    <input type="number" name="stock" id="stock" value="<?= htmlspecialchars($product->getStock()) ?>" required>

    <label for="category">Catégorie :</label>
    <input type="text" name="category" id="category" value="<?= htmlspecialchars($product->getCategory()) ?>" required>

    <button type="submit">Modifier</button>
</form>
