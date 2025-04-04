<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;

class LoginController extends AbstractController
{
    public function login()
    {
        // ⚙️ Démarrage de session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->arrayError = [];

        // ✅ Si l'utilisateur est déjà connecté, on redirige
        if (isset($_SESSION['user'])) {
            $this->redirectToRoute('/');
            exit;
        }

        // 📥 Traitement du formulaire de connexion
        if (!empty($_POST['mail']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['mail']);
            $password = $_POST['password']; // NE PAS utiliser htmlspecialchars ici !

            $user = User::authenticate($email, $password);

            if ($user) {
                // ✅ Création de la session utilisateur
                $_SESSION['user'] = [
                    'id'          => $user->getId(),
                    'email'       => $user->getEmail(),
                    'firstName'   => $user->getFirstName(),
                    'lastName'    => $user->getLastName(),
                    'phoneNumber' => $user->getPhoneNumber(),
                    'address'     => $user->getAddress(),
                    'id_Role'     => $user->getIdRole()
                ];

                // 📌 Gérer le cookie "se souvenir de moi"
                if (!empty($_POST['remember_me'])) {
                    setcookie('remembered_email', $email, time() + (86400 * 30), "/"); // 30 jours
                }

                // 🔁 Redirection après succès
                $this->redirectToRoute('/');
                exit;
            } else {
                $this->arrayError['global'] = "❌ Email ou mot de passe incorrect.";
            }
        }

        // 📄 Affichage du formulaire
        require_once(__DIR__ . '/../Views/login.view.php');
    }
}
