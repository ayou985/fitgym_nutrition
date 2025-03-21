<?php require_once(__DIR__ . "/partials/head.php"); ?>

<div class="container mt-5">
    <h1 class="text-center">Mon Profil</h1>
    <div class="profile-container">
        <form action="/profile/update" method="POST" class="profile-form">

            <div class="form-group">
                <label for="firstName">Prénom :</label>
                <input type="text" id="firstName" name="firstName"
                    value="<?= htmlspecialchars($user->getFirstName() ?? '') ?>"
                    class="form-control" required>
            </div>

            <div class="form-group">
                <label for="lastName">Nom :</label>
                <input type="text" id="lastName" name="lastName"
                    value="<?= htmlspecialchars($user->getLastName() ?? '') ?>"
                    class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email"
                    value="<?= htmlspecialchars($user->getEmail() ?? '') ?>"
                    class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Numéro de téléphone :</label>
                <input type="text" id="phoneNumber" name="phoneNumber"
                    value="<?= htmlspecialchars($user->getPhoneNumber() ?? '') ?>"
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="address">Adresse :</label>
                <input type="text" id="address" name="address"
                    value="<?= htmlspecialchars($user->getAddress() ?? '') ?>"
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" id="password" name="password"
                    class="form-control" placeholder="Laissez vide pour ne pas changer">
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirmer le mot de passe :</label>
                <input type="password" id="confirmPassword" name="confirmPassword"
                    class="form-control" placeholder="Laissez vide pour ne pas changer">
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>