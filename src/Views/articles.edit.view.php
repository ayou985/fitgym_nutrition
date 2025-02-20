<form action="/admin/article/update" method="post">
    <input type="hidden" name="id" value="<?= $article['id'] ?>">

    <label>Nom :</label>
    <input type="text" name="name" value="<?= htmlspecialchars($article['name']) ?>" required>

    <label>Description :</label>
    <textarea name="description" required><?= htmlspecialchars($article['description']) ?></textarea>

    <label>Prix :</label>
    <input type="number" name="price" step="0.01" value="<?= $article['price'] ?>" required>

    <label>Catégorie :</label>
    <input type="number" name="category_id" value="<?= $article['category_id'] ?>" required>

    <button type="submit">Modifier</button>
</form>
