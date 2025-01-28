<?php

namespace Controllers;

class AuthController {
    public function login() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Exemple de vérification des identifiants (à remplacer avec votre base de données)
            $users = [
                ['username' => 'admin', 'password' => 'admin123', 'role' => 'admin'],
                ['username' => 'user', 'password' => 'user123', 'role' => 'user']
            ];

            foreach ($users as $user) {
                if ($user['username'] === $username && $user['password'] === $password) {
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] === 'admin') {
                        header('Location: /dashboard/admin');
                        exit();
                    } elseif ($user['role'] === 'user') {
                        header('Location: /dashboard/user');
                        exit();
                    }
                }
            }

            // Si les identifiants sont incorrects
            $error = "Identifiant ou mot de passe incorrect.";
            include 'src/Views/login.view.php';
        } else {
            // Afficher le formulaire de connexion
            include 'src/Views/login.view.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
