<?php

// Démarrer la session si ce n'est pas déjà fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
    <?php $baseUrl = ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') ? '/fitgym_nutrition-main' : ''; ?>
</head>
<body>
    <div class="container">
        <h1>Vous avez été déconnecté avec succès !</h1>
        <p>Merci de votre visite. Vous allez être redirigé vers la page d'accueil dans quelques secondes...</p>
        
        <!-- Redirection automatique après quelques secondes -->
        <meta http-equiv="refresh" content="3;url=<?= $baseUrl ?>/">
        <a href="<?= $baseUrl ?>/" class="btn">Retour à l'accueil</a>
    </div>
</body>
</html>
