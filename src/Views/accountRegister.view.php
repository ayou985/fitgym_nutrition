<?php

require_once(__DIR__ . "/partials/head.php");

?>


<div class="container">
    <h1>Inscription / Connexion</h1>
    <form  method="POST">
        <p>Veuillez remplir les champs indiqués ci-dessous afin de créer votre compte.</p>
        <input type="name" placeholder="Nom"><br>
        <input type="name" placeholder="Prénom"><br>
        <input type="email" placeholder="Email"><br>
        <input type="password" placeholder="Mot de passe"><br>
        <input type="password" placeholder="Confirmer le mot de passe"><br>
        <input type="button" value="Je m'inscris"><br>
    </form>
    <p>Vous n'avez pas de compte ? <a href="/register">Inscrivez-vous</a></p>
</div>




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