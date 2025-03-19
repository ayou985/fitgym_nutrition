<a href="/createProduct" class="btn btn-success">➕ Ajouter</a>
<a href="/editProduct?id=<?= $product['id'] ?>" class="btn btn-warning">✏️ Modifier</a>
<a href="/deleteProduct?id=<?= $product['id'] ?>" class="btn btn-danger">🗑️ Supprimer</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th> <!-- Nouvelle colonne pour l'image -->
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id']) ?></td>

                <!-- Affichage de l'image -->
                <td>
                    <img src="<?= htmlspecialchars($product['image']); ?>"
                        alt="<?= htmlspecialchars($product['name']); ?>"
                        style="max-width: 80px; height: auto; border: 1px solid #ddd;">
                </td>

                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?> €</td>
                <td>
                    <a href="/editProduct?id=<?= $product['id'] ?>" class="btn btn-warning">✏️ Modifier</a>
                    <a href="/deleteProduct?id=<?= $product['id'] ?>" class="btn btn-danger">🗑️ Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>