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
    <link rel="stylesheet" href="/path/to/your/styles.css"> <!-- Inclure votre fichier CSS ici -->
</head>
<body>
    <div class="container">
        <h1>Vous avez été déconnecté avec succès !</h1>
        <p>Merci de votre visite. Vous allez être redirigé vers la page d'accueil dans quelques secondes...</p>
        
        <!-- Redirection automatique après quelques secondes -->
        <meta http-equiv="refresh" content="3;url=/">

        <!-- Optionnellement, tu peux ajouter un bouton pour rediriger immédiatement -->
        <a href="/" class="btn">Retour à l'accueil</a>
    </div>
</body>
</html>
