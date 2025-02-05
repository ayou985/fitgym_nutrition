<?php  

namespace App\Controllers;

use App\Utils\AbstractController;

class LogoutController extends AbstractController
{
    public function logout()
    {
        // Vérifier et démarrer la session si elle n'est pas déjà démarrée
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Supprimer toutes les variables de session
        session_unset();

        // Détruire la session
        session_destroy();
        header("Location: /");

        // Rediriger vers la page d'accueil après la déconnexion
        $this->redirectToRoute('/'); // Ou la page que tu veux
    }
}
