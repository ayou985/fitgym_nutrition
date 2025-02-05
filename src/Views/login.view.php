<?php
require_once(__DIR__ . "/partials/head.php");

// On s'assure que $arrayError est défini
$arrayError = $arrayError ?? [];
?>

<h1>Connexion</h1>

<form method='POST'>
    <div>
        <label for="mail">Email</label>
        <input type="email" name='mail' required>
        <?php if (isset($arrayError['mail'])) { ?>
            <p class='text-danger'><?= $arrayError['mail'] ?></p>
        <?php } ?>
    </div>

    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name='password' required>
        <?php if (isset($arrayError['password'])) { ?>
            <p class='text-danger'><?= $arrayError['password'] ?></p>
        <?php } ?>
    </div>

    <button type="submit">Se connecter</button>

    <?php if (isset($arrayError['global'])) { ?>
        <p class='text-danger'><?= $arrayError['global'] ?></p>
    <?php } ?>
</form>

<?php
require_once(__DIR__ . '/partials/footer.php');
?>
