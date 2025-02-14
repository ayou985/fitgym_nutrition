<?php require_once 'partials/head.php'; ?>

<h2>Modifier l'article</h2>
<form action="index.php?controller=article&action=update&id=<?= $article['id'] ?>" method="POST">
    <label for="title">Titre :</label>
    <input type="text" name="title" value="<?= $article['title'] ?>" required><br>
    
    <label for="content">Contenu :</label>
    <textarea name="content" required><?= $article['content'] ?></textarea><br>
    
    <button type="submit">Mettre à jour</button>
</form>

<?php require_once 'partials/footer.php'; ?>
