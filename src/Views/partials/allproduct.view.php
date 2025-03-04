<a href="/admin/product/create" class="btn btn-success">➕ Ajouter</a>

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
                    <a href="/admin/product/create" class="btn btn-primary">Créer un product</a>
                    <a href="/admin/product/edit?id=1" class="btn btn-warning">Modifier</a>
                    <a href="/admin/product/delete?id=1" class="btn btn-danger">Supprimer</a>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>