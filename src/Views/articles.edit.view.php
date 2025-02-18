<h1>Modifier <?= $article['name'] ?></h1>
<form method="post">
    <label>Nom :</label>
    <input type="text" name="name" value="<?= $article['name'] ?>" required>
    
    <label>Description :</label>
    <textarea name="description" required><?= $article['description'] ?></textarea>

    <label>Prix :</label>
    <input type="number" name="price" value="<?= $article['price'] ?>" step="0.01" required>

    <label>Catégorie :</label>
    <input type="number" name="category_id" value="<?= $article['category_id'] ?>" required>

    <button type="submit">Modifier</button>
</form>
<a href="/allarticle">Annuler</a>
