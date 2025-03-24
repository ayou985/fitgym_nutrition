<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{

    // ✅ Afficher le profil de l'utilisateur
    public function profile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        // Correction : Utiliser `getUserById()` au lieu de `getById()`
        $user = User::getUserById($_SESSION['user']['id']);

        require_once(__DIR__ . "/../Views/profile.view.php");
    }

    // ✅ Modifier les informations du profil
    public function updateProfile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $id = $_SESSION['user']['id'];
        $email = $_POST['email'] ?? '';
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $phoneNumber = $_POST['phoneNumber'] ?? '';
        $address = $_POST['address'] ?? '';

        if ($email && $firstName && $lastName) {
            $user = User::getUserById($id);
            if ($user) {
                $user->setEmail($email);
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setPhoneNumber($phoneNumber);
                $user->setAddress($address);

                // Correction : Utiliser `updateUser()` au lieu de `update()`
                $user->updateUser();

                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['firstName'] = $firstName;
                $_SESSION['user']['lastName'] = $lastName;
                $_SESSION['user']['phoneNumber'] = $phoneNumber;
                $_SESSION['user']['address'] = $address;
            }
        }

        header("Location: /profile");
        exit();
    }


    public function updateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $phone = $_POST['phoneNumber'];
            $address = $_POST['address'];
            $idRole = $_POST['idRole'];

            $user = new \App\Models\User(
                $id,
                $email,
                null, // mot de passe non modifié ici
                $firstName,
                $lastName,
                $phone,
                $address,
                $idRole
            );

            if ($user->updateUser()) {
                header("Location: /listUsers");
                exit;
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        } else {
            echo "Méthode non autorisée.";
        }
    }

    public function editUser()
    {


        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
            header("Location: /editUser");
            exit();
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            die("ID utilisateur manquant");
        }
        $id = intval($_GET['id']);
        $user = User::getUserById($id);


        $user = User::getUserById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newRole = $_POST['id_Role'] ?? null;
            if ($newRole !== null) {
                User::updateRole($id, $newRole);
                header("Location: /editUser");
                exit();
            }
        }

        require_once(__DIR__ . "/../Views/editUser.view.php");
    }

    public function deleteUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
            header("Location: /deleteUser");
            exit();
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            User::getUserById($id);
        }

        header("Location: /deleteUser");
        exit();
    }


    // ✅ Modifier le mot de passe
    public function changePassword()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $id = $_SESSION['user']['id'];
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';

        if ($oldPassword && $newPassword) {
            $user = User::getUserById($id);
            if ($user && password_verify($oldPassword, $user->getPassword())) {
                // Correction : Assurer le hashage du nouveau mot de passe
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                User::updatePassword($id, $hashedPassword);
            }
        }

        header("Location: /profile");
        exit();
    }

    public function listUsers()
    {


        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']['id_Role']) || $_SESSION['user']['id_Role'] != 1) {
            die("Erreur : Accès refusé.");
            exit();
        }

        // Récupérer tous les utilisateurs
        $users = User::getAll();

        require_once(__DIR__ . "/../Views/listUsers.view.php");
    }
    // ✅ Supprimer le compte
    public function deleteAccount()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: /deleteUser");
            exit();
        }

        $id = $_SESSION['user']['id'];

        // Correction : Utiliser `deleteUser()` au lieu de `delete()`
        User::getUserById($id)->deleteUser();

        session_destroy();

        header("Location: /deleteUser");
        exit();
    }
}
