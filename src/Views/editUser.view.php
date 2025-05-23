<?php require_once(__DIR__ . "/partials/head.php"); ?>

<div class="container mt-5">
    <h2 class="text-center">Modifier l'utilisateur</h2>

    <?php if (isset($user)) : ?>
        <form action="/editUser?id=<?= $user->getId() ?>" method="POST" class="mt-4">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user->getId() ?? '') ?>">

            <div class="mb-3">
                <label for="lastName" class="form-label">Nom :</label>
                <input type="text" id="lastName" name="name" class="form-control"
                    value="<?= htmlspecialchars($user->getLastName() ?? '') ?>">
            </div>

            <!-- Prénom -->
            <div class="mb-3">
                <label for="firstName" class="form-label">Prénom :</label>
                <input type="text" id="firstName" name="firstName" class="form-control"
                    value="<?= htmlspecialchars($user->getFirstName() ?? '') ?>">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="<?= htmlspecialchars($user->getEmail() ?? '') ?>">
            </div>


            <!-- Numéro de téléphone -->
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Téléphone :</label>
                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                    value="<?= htmlspecialchars($user->getPhoneNumber() ?? '') ?>">
            </div>

            <!-- Adresse -->
            <div class="mb-3">
                <label for="address" class="form-label">Adresse :</label>
                <input type="text" id="address" name="address" class="form-control"
                    value="<?= htmlspecialchars($user->getAddress() ?? '') ?>">
            </div>

            <!-- Rôle -->
            <div class="mb-3">
                <label for="idRole" class="form-label">Rôle :</label>
                <select id="id_Role" name="id_Role" class="form-control">
                    <option value="1" <?= ($user->getIdRole() == 1) ? 'selected' : '' ?>>Admin</option>
                    <option value="2" <?= ($user->getIdRole() == 2) ? 'selected' : '' ?>>Utilisateur</option>
                </select>

            </div>

            <!-- Boutons -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="/listUsers" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    <?php else : ?>
        <p class="text-center text-danger">Erreur : utilisateur introuvable.</p>
    <?php endif; ?>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>