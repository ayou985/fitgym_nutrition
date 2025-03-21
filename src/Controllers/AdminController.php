<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;

class AdminController extends AbstractController
{
    public function manageUsers()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Vérifier si l'utilisateur est un admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
            die("Accès refusé.");
        }

        // Récupérer tous les utilisateurs
        $users = User::getAll();

        require_once(__DIR__ . "/../Views/admin.view.php");
    }

    public function updateRole()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
            die("Accès refusé.");
        }

        if (isset($_POST['user_id'], $_POST['role'])) {
            $userId = intval($_POST['user_id']);
            $newRole = intval($_POST['role']);

            User::updateRole($userId, $newRole);
        }

        $this->redirectToRoute('/profile');
    }
}