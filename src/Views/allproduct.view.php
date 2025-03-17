<a href="/createProduct" class="btn btn-success">➕ Ajouter</a>
<a href="/editProduct?id=<?= $product['id'] ?>" class="btn btn-warning">✏️ Modifier</a>
<a href="/delete?id=<?= $product['id'] ?>" class="btn btn-danger">🗑️ Supprimer</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
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
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?> €</td>
                <td>
                    <a href="/createProduct" class="btn btn-primary">Créer un product</a>
                    <a href="/editProduct?id=" class="btn btn-warning">Modifier</a>
                    <a href="/delete" class="btn btn-danger">Supprimer</a>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>