<?php
require_once(__DIR__ . '/../Views/partials/head.php');
?>

<h1>Liste des articles</h1>

<div class="container mt-5">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix (€)</th>
                <th>Stock</th>
                <th>Catégorie</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article) { ?>
                <tr>
                    <td><?= htmlspecialchars($article['id']) ?></td>
                    <td><?= htmlspecialchars($article['name']) ?></td>
                    <td><?= htmlspecialchars($article['description']) ?></td>
                    <td><?= htmlspecialchars($article['price']) ?></td>
                    <td><?= htmlspecialchars($article['stock']) ?></td>
                    <td><?= htmlspecialchars($article['category']) ?></td>
                    <td>
                        <?php if (!empty($article['image'])) { ?>
                            <img src="/uploads/<?= htmlspecialchars($article['image']) ?>" alt="Image de l'article" width="80">
                        <?php } else { ?>
                            <p class="text-muted">Pas d'image</p>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="/admin/article/edit/<?= $article['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="/admin/article/delete/<?= $article['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
require_once(__DIR__ . '/../Views/partials/footer.php');
?>
