<?php require_once(__DIR__ . "/partials/head.php"); ?>

<div class="container">
    <h1 class="text-center mt-4">Liste des Utilisateurs</h1>

    <?php if (!empty($users)) : ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['lastName']) ?></td>
                        <td><?= htmlspecialchars($user['firstName']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['phoneNumber'] ?? 'Non renseigné') ?></td>
                        <td><?= htmlspecialchars($user['address'] ?? 'Non renseignée') ?></td>
                        <td><?= $user['id_Role'] == 1 ? 'Admin' : 'Utilisateur' ?></td>
                        <td>
                            <a href="/profile?id=<?= $user['id'] ?>" class="btn btn-primary">Voir</a>
                            <a href="/editUser?id=<?= $user['id'] ?>" class="btn btn-warning">Modifier</a>
                            <a href="/profile/delete?id=<?= $user['id'] ?>" class="btn btn-danger"
                                onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="text-center">Aucun utilisateur trouvé.</p>
    <?php endif; ?>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>