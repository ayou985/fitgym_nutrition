<?php require_once(__DIR__ . "/partials/head.php"); ?>

<div class="container">
    <h1 class="text-center mt-4">Modifier l'utilisateur</h1>

    <form action="" method="POST" class="mt-4">
        <div class="form-group">
            <label>Nom :</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user->getFirstName()) ?>" disabled>
        </div>

        <div class="form-group">
            <label>Email :</label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($user->getEmail()) ?>" disabled>
        </div>

        <div class="form-group">
            <label>Rôle :</label>
            <select name="id_Role" class="form-control">
                <option value="1" <?= ($user->getId_Role() == 1) ? "selected" : "" ?>>Admin</option>
                <option value="2" <?= ($user->getId_Role() == 2) ? "selected" : "" ?>>Utilisateur</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Mettre à jour</button>
        <a href="/admin/users" class="btn btn-secondary mt-3">Retour</a>
    </form>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>
