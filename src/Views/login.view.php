<?php
require_once(__DIR__ . "/partials/head.php");

// On s'assure que $arrayError est défini
$arrayError = $arrayError ?? [];
$rememberedEmail = $_COOKIE['remembered_email'] ?? ''; // Récupération du cookie s'il existe
?>

<div class="container">
    <form method="POST" action="" class="register-form">
        <h1>Connexion</h1>
        <p class="text-center">Connectez-vous à votre compte FitGym.</p>

        <div>
            <label for="mail">Email</label>
            <input type="email" name="mail" id="mail" value="<?= htmlspecialchars($rememberedEmail) ?>" required autocomplete="username">
            <?php if (isset($arrayError['mail'])) { ?>
                <p class="text-danger"><?= $arrayError['mail'] ?></p>
            <?php } ?>
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required autocomplete="current-password">
            <?php if (isset($arrayError['password'])) { ?>
                <p class="text-danger"><?= $arrayError['password'] ?></p>
            <?php } ?>
        </div>

        <div style="margin-bottom: 20px;">
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Se souvenir de moi</label>
        </div>

        <button type="submit">Se connecter</button>

        <?php if (isset($arrayError['global'])) { ?>
            <p class="text-danger"><?= $arrayError['global'] ?></p>
        <?php } ?>
    </form>
</div>

<?php
require_once(__DIR__ . '/partials/footer.php');
?>
