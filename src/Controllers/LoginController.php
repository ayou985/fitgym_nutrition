<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;

class LoginController extends AbstractController
{
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = null;

        if (!empty($_POST['mail']) && !empty($_POST['password'])) {
            $mail = htmlspecialchars($_POST['mail']);
            $password = htmlspecialchars($_POST['password']);

            // Vérification de l'utilisateur en base de données
            $user = User::authenticate($mail, $password);

            
            if ($user) {
                // Stocker les infos de l'utilisateur en session
                $_SESSION['user'] = [
                    'id'          => $user->getId(),
                    'email'       => $user->getEmail(),
                    'firstName'   => $user->getFirstName(),
                    'lastName'    => $user->getLastName(),
                    'phoneNumber' => $user->getPhoneNumber(),
                    'address'     => $user->getAddress(),
                    'id_Role'      => $user->getIdRole()
                ];

                // Redirection après connexion
                $this->redirectToRoute('/');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        }

        // Redirection si l'utilisateur est déjà connecté
        if (isset($_SESSION['user'])) {
            $this->redirectToRoute('/');
            exit();
        }

        require_once(__DIR__ . "/../Views/login.view.php");
    }
}
