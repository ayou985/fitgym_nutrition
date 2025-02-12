<?php

namespace App\Controllers;

use App\Models\User;
use Config\DataBase;

class AuthController
{

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['mail']);
            $password = trim($_POST['password']);

            // Récupérer l'utilisateur par son email
            $userModel = new User(null, null, null, null, null, null, null, null);
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user->getPassword())) {
                // Démarrer la session et enregistrer les informations utilisateur
                $_SESSION['username'] = $user->getName(); // Assurez-vous que getName() récupère bien le nom de l'utilisateur

                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['username'] = $user->getFirstName() . ' ' . $user->getLastName();
                $_SESSION['role'] = $user->getIdRole();

                // Redirection vers le tableau de bord selon le rôle
                if ($user['id_role'] == 1) {
                    header('Location: /'); // Redirige vers l'accueil pour les admins
                } else {
                    header('Location: /profile'); // Redirige vers une page profil utilisateur
                }
                exit;
            } else {
                // Identifiants incorrects
                $error = "Email ou mot de passe incorrect.";
                require_once __DIR__ . '/../Views/login.view.php';
            }
        } else {
            // Afficher la vue de connexion
            require_once __DIR__ . '/../Views/login.view.php';
        }
    }

    public function suggestPassword()
    {
        if (isset($_COOKIE['remembered_email'])) {
            $email = $_COOKIE['remembered_email'];
        } else {
            $email = '';
        }

        require_once __DIR__ . '/../../views/auth/suggest_password.php';
    }

    public function verifyAuth()
    {

        if (isset($_SESSION['user_id'])) {
            echo json_encode(['authenticated' => true]);
        } else {
            echo json_encode(['authenticated' => false]);
        }
    }

    public function logout()
    {

        session_destroy();
        header('Location: /login');
        exit;
    }
}
