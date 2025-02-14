<?php require_once 'partials/head.php'; ?>

<h2>Ajouter un article</h2>
<form action="index.php?controller=article&action=store" method="POST">
    <label for="title">Titre :</label>
    <input type="text" name="title" required><br>
    
    <label for="content">Contenu :</label>
    <textarea name="content" required></textarea><br>
    
    <button type="submit">Enregistrer</button>
</form>

<?php require_once 'partials/footer.php'; ?>
