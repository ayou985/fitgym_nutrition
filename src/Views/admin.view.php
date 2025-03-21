<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Tableau de bord administrateur</title>
</head>

<body>
    <h1>Bienvenue, administrateur !</h1>
    <p>Ceci est votre espace administrateur.</p>
    <a href="/logout">Déconnexion</a>
</body>

</html>


<form action="index.php?page=add_product" method="POST">
    <label>Nom du produit</label>
    <input type="text" name="name" required>

    <label>Description</label>
    <textarea name="description" required></textarea>

    <label>Prix</label>
    <input type="number" name="price" step="0.01" required>

    <label>Image (URL)</label>
    <input type="text" name="image">

    <button type="submit">Ajouter</button>
</form>

<table>
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Image</th>
    </tr>
    <?php if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
        header("Location: user_dashboard.php"); // Redirige les non-admins
        exit;
    }
    ?>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= htmlspecialchars($product['description']) ?></td>
            <td><?= htmlspecialchars($product['price']) ?>€</td>
            <td><img src="<?= htmlspecialchars($product['image']) ?>" width="50"></td>
        </tr>
    <?php endforeach; ?>
</table>