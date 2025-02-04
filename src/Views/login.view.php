<?php

require_once(__DIR__ . "/partials/head.php");

?>


<h1>Inscription</h1>
<form method='POST'>
    <div>
        <label for="mail">Mail</label>
        <input type="email" name='mail'>
        <?php if (isset($this->arrayError['mail'])) {
        ?>
            <p class='text-danger'><?= $this->arrayError['mail'] ?></p>
        <?php
        } ?>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name='password'>
        <?php if (isset($this->arrayError['password'])) {
        ?>
            <p class='text-danger'><?= $this->arrayError['password'] ?></p>
        <?php
        } ?>
    </div>
    <button type="submit">Connexion</button>
</form>

<?php
if (isset($error)) {
    echo "<p class='text-danger'>" . $error . "<p>";
}




require_once(__DIR__ . '/partials/footer.php')

?>