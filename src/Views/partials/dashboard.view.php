<h2>Gestion des utilisateurs</h2>

<?php if (!empty($users)): ?>
    <table border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Nom</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']); ?></td>
                <td><?= htmlspecialchars($user['email']); ?></td>
                <td><?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></td>
                <td>
                    <?= $user['id_Role'] == 2 ? '<strong>Admin</strong>' : 'Utilisateur'; ?>
                </td>
                <td>
                    <?php if ($user['id_Role'] == 1): ?>
                        <a href="updateRole.php?id=<?= htmlspecialchars($user['id']); ?>&role=2">Passer Admin</a>
                    <?php elseif ($user['id_Role'] == 2): ?>
                        <a href="updateRole.php?id=<?= htmlspecialchars($user['id']); ?>&role=1">Rétrograder</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Aucun utilisateur trouvé.</p>
<?php endif; ?>
