<?php

require_once(__DIR__ . "/partials/head.php");

?>




<div class="container">
    <h1>Inscription / Connexion</h1>
    <form method="POST" class="formulaire-inscription">

        <p>Veuillez remplir les champs indiqués ci-dessous afin de créer votre compte.</p>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm-password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm-password" name="confirm-password" required>

        <button type="submit">S'inscrire</button>

    </form>






        <div class="container">
            <form>
                <p>Bienvenue</p>
                <input type="email" placeholder="Email"><br>
                <input type="password" placeholder="Mot de passe"><br>
                <input type="button" value="Connexion"><br>
                <a href="#">Mot de passe oublié</a>
            </form>

        </div>


        <?php

        require_once(__DIR__ . "/partials/footer.php");

        ?>