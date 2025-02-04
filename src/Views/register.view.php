<?php

require_once(__DIR__ . "/partials/head.php");

?>


<div class="container">
    <h1>Inscription</h1>
    <form method="POST" class="formulaire-inscription">

        <p>Veuillez remplir les champs indiqués ci-dessous afin de créer votre compte.</p>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="lastName" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="firstName" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm-password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm-password" name="confirm-password" required>

        <button type="submit">S'inscrire</button>

    </form>

<?php

require_once(__DIR__ . "/partials/footer.php");

?>