<?php
require_once 'partials/head.php';
?>

<h2>Liste des articles</h2>
<a href="index.php?controller=article&action=create" class="btn btn-primary">Ajouter un article</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Contenu</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($articles as $article) : ?>
        <tr>
            <td><?= $article['id'] ?></td>
            <td><?= $article['title'] ?></td>
            <td><?= $article['content'] ?></td>
            <td>
                <a href="index.php?controller=article&action=edit&id=<?= $article['id'] ?>">Modifier</a>
                <a href="index.php?controller=article&action=delete&id=<?= $article['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once 'partials/footer.php'; ?>
