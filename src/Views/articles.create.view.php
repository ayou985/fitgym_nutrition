<form action="/admin/article/store" method="post">
    <label>Nom :</label>
    <input type="text" name="name" required>

    <label>Description :</label>
    <textarea name="description" required></textarea>

    <label>Prix :</label>
    <input type="number" name="price" step="0.01" required>

    <label>Catégorie :</label>
    <input type="number" name="category_id" required>

    <button type="submit">Ajouter</button>
</form>
