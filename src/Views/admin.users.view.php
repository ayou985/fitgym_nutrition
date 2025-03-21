<?php require_once(__DIR__ . "/partials/head.php"); ?>

<div class="container">
    <h1 class="text-center mt-4">Gestion des Utilisateurs</h1>

    <table class="table table-dark mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['firstName'] . " " . $user['lastName']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= ($user['id_Role'] == 1) ? "Admin" : "Utilisateur" ?></td>
                    <td>
                        <a href="/editUser?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="/deleteUser?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>