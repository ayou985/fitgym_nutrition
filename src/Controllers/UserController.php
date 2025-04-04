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

        $user = User::getUserById($_SESSION['user']['id']);
        require_once(__DIR__ . "/../Views/profile.view.php");
    }

    // ✅ Modifier les informations du profil + mot de passe
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

                // ✅ TRAITEMENT DE L'IMAGE
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

                    if (in_array($ext, $allowed)) {
                        $newName = uniqid() . '.' . $ext;
                        move_uploaded_file($_FILES['profile_image']['tmp_name'], 'public/uploads/' . $newName);
                        $user->setProfileImage($newName);
                        $_SESSION['user']['profile_image'] = $newName;
                    }
                }

                // ✅ TRAITEMENT DU MOT DE PASSE
                $newPassword = $_POST['new_password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                if (!empty($newPassword) || !empty($confirmPassword)) {
                    if ($newPassword !== $confirmPassword) {
                        $_SESSION['error'] = "❌ Les mots de passe ne correspondent pas.";
                        header("Location: /profile");
                        exit;
                    }

                    // (optionnel) ajout vérification de complexité
                    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#?!@$%^&*-]).{8,}$/', $newPassword)) {
                        $_SESSION['error'] = "❌ Le mot de passe n'est pas assez sécurisé.";
                        header("Location: /profile");
                        exit;
                    }

                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    User::updatePassword($user->getId(), $hashedPassword);
                }

                echo "<pre>";
                var_dump([
                    'newPassword' => $newPassword,
                    'confirmPassword' => $confirmPassword,
                    'match' => $newPassword === $confirmPassword,
                    'regex_ok' => preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#?!@$%^&*-]).{8,}$/', $newPassword)
                ]);
                echo "</pre>";
                exit;



                // ✅ Mise à jour en BDD
                $user->updateUser();

                // Mise à jour de la session
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['firstName'] = $firstName;
                $_SESSION['user']['lastName'] = $lastName;
                $_SESSION['user']['phoneNumber'] = $phoneNumber;
                $_SESSION['user']['address'] = $address;

                header("Location: /profile");
                exit();
            }
        }
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
                null,
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
            User::getUserById($id)->deleteUser();
        }

        header("Location: /deleteUser");
        exit();
    }

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
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                User::updatePassword($id, $hashedPassword);
            }
        }

        header("Location: /profile");
        exit();
    }

    public function listUsers()
    {
        if (!isset($_SESSION['user']['id_Role']) || $_SESSION['user']['id_Role'] != 1) {
            die("Erreur : Accès refusé.");
        }

        $users = User::getAll();
        require_once(__DIR__ . "/../Views/listUsers.view.php");
    }

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
        User::getUserById($id)->deleteUser();

        session_destroy();
        header("Location: /deleteUser");
        exit();
    }
}
