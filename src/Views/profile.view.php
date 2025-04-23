<?php require_once(__DIR__ . "/partials/head.php"); ?>

<?php if (!empty($_SESSION['flash'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '<?= $_SESSION["flash"]["type"] ?>',
            title: '<?= $_SESSION["flash"]["type"] === "success" ? "Succès !" : "Erreur" ?>',
            text: '<?= $_SESSION["flash"]["message"] ?>',
            confirmButtonColor: '#3085d6'
        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>


<div class="container mt-5">
    <h1 class="text-center">Mon Profil</h1>

    <!-- Photo de profil -->
    <div class="text-center mb-4">
        <?php if (!empty($user->getProfileImage())): ?>
            <img src="/public/uploads/<?= htmlspecialchars($user->getProfileImage()) ?>" width="150" class="rounded-circle" alt="Photo de profil">
        <?php else: ?>
            <img src="public/img/profile-user.png" width="150" class="rounded-circle" alt="Photo par défaut">
        <?php endif; ?>
    </div>

    <!-- Formulaire de mise à jour -->
    <div class="profile-container">
        <form action="/profile/update" method="POST" enctype="multipart/form-data" class="profile-form">

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
                <label for="old_password">Ancien mot de passe :</label>
                <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Entrez votre mot de passe actuel">
            </div>

            <div class="form-group">
                <label for="new_password">Nouveau mot de passe :</label>
                <input type="password" id="new_password" name="new_password"
                    class="form-control" placeholder="Laissez vide pour ne pas changer">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password"
                    class="form-control" placeholder="Laissez vide pour ne pas changer">
            </div>


            <div class="form-group">
                <label for="profile_image">Changer la photo de profil :</label>
                <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</div>

<div class="text-center mt-4">
    <button class="btn btn-danger" id="delete-account-btn">
        <i class="fa fa-trash-alt"></i> Supprimer mon compte
    </button>
</div>


<script>
    function confirmDeleteAccount() {
        return confirm("⚠️ Cette action est irréversible. Es-tu sûr de vouloir supprimer ton compte ?");
    }
</script>


<script>
    document.querySelector("form").addEventListener("submit", function(e) {
        const oldPass = document.querySelector('input[name="old_password"]');
        const newPass = document.querySelector('input[name="new_password"]');
        const confirmPass = document.querySelector('input[name="confirm_password"]');

        // Si on veut changer le mdp
        if (newPass.value !== '' || confirmPass.value !== '') {
            if (oldPass.value === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Ancien mot de passe requis',
                    text: 'Veuillez entrer votre ancien mot de passe pour modifier le mot de passe.',
                });
            }
        }
    });
</script>

<script>
    document.getElementById('delete-account-btn').addEventListener('click', function() {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "⚠️ Cette action est irréversible. Votre compte sera définitivement supprimé.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/profile/delete', {
                    method: 'POST'
                }).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Compte supprimé',
                        text: 'Votre compte a été supprimé avec succès.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = '/';
                    });
                });
            }
        });
    });
</script>




<?php require_once(__DIR__ . "/partials/footer.php"); ?>