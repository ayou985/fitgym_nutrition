<?php
require_once(__DIR__ . "../partials/head.php");
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
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['stock']) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td>
                        <?php if (!empty($product['image'])) { ?>
                            <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" alt="Image de l'article" width="80">
                        <?php } else { ?>
                            <p class="text-muted">Pas d'image</p>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="/edit?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="/edit?id=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
require_once(__DIR__ . "../partials/footer.php");
?>
