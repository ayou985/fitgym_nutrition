<a href="/admin/article/create" class="btn btn-success">➕ Ajouter</a>

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
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= htmlspecialchars($article['id']) ?></td>
                <td><?= htmlspecialchars($article['name']) ?></td>
                <td><?= htmlspecialchars($article['description']) ?></td>
                <td><?= htmlspecialchars($article['price']) ?> €</td>
                <td>
                    <a href="/admin/article/create" class="btn btn-primary">Créer un article</a>
                    <a href="/admin/article/edit?id=1" class="btn btn-warning">Modifier</a>
                    <a href="/admin/article/delete?id=1" class="btn btn-danger">Supprimer</a>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>