<?php
require_once(__DIR__ . "/partials/head.php");

$arrayError = $arrayError ?? [];
$rememberedEmail = $_COOKIE['remembered_email'] ?? '';
?>

<div class="container">
    <form method="POST" action="" class="register-form">
        <h1>Connexion</h1>
        <p class="text-center">Connectez-vous à votre compte FitGym.</p>

        <!-- Email -->
        <div>
            <label for="mail">Email</label>
            <input type="email" name="mail" id="mail" value="<?= htmlspecialchars($rememberedEmail) ?>" required autocomplete="username">
            <?php if (!empty($arrayError['mail'])): ?>
                <p class="text-danger"><?= $arrayError['mail'] ?></p>
            <?php endif; ?>
        </div>

        <!-- Mot de passe avec icône -->
        <div style="position: relative;">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required autocomplete="current-password" style="padding-right: 35px;">
            <span onclick="toggleLoginPassword()" style="position: absolute; right: 10px; top: 38px; cursor: pointer;">👁️</span>
            <?php if (!empty($arrayError['password'])): ?>
                <p class="text-danger"><?= $arrayError['password'] ?></p>
            <?php endif; ?>
        </div>

        <!-- Se souvenir -->
        <div style="margin-bottom: 20px;">
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Se souvenir de moi</label>
        </div>

        <!-- Bouton -->
        <button type="submit">Se connecter</button>

        <!-- Erreur globale -->
        <?php if (!empty($arrayError['global'])): ?>
            <p class="text-danger"><?= $arrayError['global'] ?></p>
        <?php endif; ?>
    </form>
</div>

<?php if (isset($_SESSION['flash'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '<?= $_SESSION['flash']['type'] ?>',
            title: '<?= $_SESSION['flash']['message'] ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33',
        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>


<!-- 👁️ JS pour mot de passe -->
<script>
    function toggleLoginPassword() {
        const pwd = document.getElementById("password");
        pwd.type = pwd.type === "password" ? "text" : "password";
    }
</script>

<?php require_once(__DIR__ . '/partials/footer.php'); ?>
