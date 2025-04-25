<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $user = User::getUserById($_SESSION['user']['id']);
        require_once(__DIR__ . "/../Views/profile.view.php");
    }


    public function updateProfile()
    {

        session_start();

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
        $user = User::getUserById($id);

        if ($user && $email && $firstName && $lastName) {
            $user->setEmail($email)
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setPhoneNumber($phoneNumber)
                ->setAddress($address);

            // ✅ Traitement image
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

            // ✅ Gestion du mot de passe
            $oldPassword = $_POST['old_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Si l'utilisateur tente de changer le mot de passe
            if (!empty($oldPassword) || !empty($newPassword) || !empty($confirmPassword)) {

                // Tous les champs doivent être remplis
                if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => '❌ Tous les champs de mot de passe doivent être remplis.'
                    ];
                    header("Location: /profile");
                    exit;
                }

                // Vérification de l'ancien mot de passe
                if (!password_verify($oldPassword, $user->getPassword())) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => '❌ Ancien mot de passe incorrect.'
                    ];
                    header("Location: /profile");
                    exit;
                }

                // Vérification de la confirmation
                if ($newPassword !== $confirmPassword) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => '❌ Les mots de passe ne correspondent pas.'
                    ];
                    header("Location: /profile");
                    exit;
                }

                // Vérification de la complexité
                if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#?!@$%^&*-]).{8,}$/', $newPassword)) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "❌ Mot de passe trop faible. Il doit contenir 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial."
                    ];
                    header("Location: /profile");
                    exit;
                }

                // Ne pas permettre de reprendre le même mot de passe
                if (password_verify($newPassword, $user->getPassword())) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "❌ Le nouveau mot de passe ne peut pas être identique à l'ancien."
                    ];
                    header("Location: /profile");
                    exit;
                }

                // ✅ Si tout est bon, mise à jour
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                \App\Models\User::updatePassword($user->getId(), $hashedPassword);

                // 🔐 Déconnexion après changement de mot de passe
                session_destroy();
                session_start(); // pour recréer une session et afficher le flash message
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => '🔐 Mot de passe changé avec succès. Veuillez vous reconnecter.'
                ];
                header("Location: /login");
                exit;
            }

            // ✅ MAJ infos utilisateur
            $user->updateUser();

            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['firstName'] = $firstName;
            $_SESSION['user']['lastName'] = $lastName;
            $_SESSION['user']['phoneNumber'] = $phoneNumber;
            $_SESSION['user']['address'] = $address;

            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => "Profil mis à jour avec succès."
            ];
            header("Location: /profile");
            exit;
        }
    }


    public function updateUser()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] !== 1) {
            header("Location: /");
            exit();
        }

        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['id_Role'] ?? 2;

        if ($id && $name && $email) {
            $user = \App\Models\User::getUserById($id);

            if ($user) {
                $user->updateUser($name, $email, $role);
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "✅ Utilisateur mis à jour avec succès."
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "❌ Utilisateur introuvable."
                ];
            }
        } else {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => "❌ Données incomplètes."
            ];
        }

        header("Location: /listUsers");
        exit();
    }

    public function deleteAccount()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $id = $_SESSION['user']['id'];
        User::getUserById($id)->deleteUser();
        session_destroy();

        header("Location: /");
        exit();
    }

    public function listUsers()
    {

        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] !== 1) {
            die("Accès interdit");
        }

        $users = User::getAll();
        require_once(__DIR__ . '/../Views/listUsers.view.php');
    }

    public function editUser()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] !== 1) {
            header("Location: /");
            exit();
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            die("ID utilisateur manquant");
        }

        $user = \App\Models\User::getUserById($id);

        if (!$user) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => "❌ Utilisateur introuvable."
            ];
            header("Location: /listUsers");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ➔ On récupère les données POST
            $lastName = trim($_POST['name'] ?? '');
            $firstName = trim($_POST['firstName'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phoneNumber = trim($_POST['phoneNumber'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $role = $_POST['id_Role'] ?? $user->getIdRole();

            // ➔ Si un champ est vide, on garde l'ancien
            $user->setLastName($lastName !== '' ? $lastName : $user->getLastName())
                ->setFirstName($firstName !== '' ? $firstName : $user->getFirstName())
                ->setEmail($email !== '' ? $email : $user->getEmail())
                ->setPhoneNumber($phoneNumber !== '' ? $phoneNumber : $user->getPhoneNumber())
                ->setAddress($address !== '' ? $address : $user->getAddress())
                ->setId_Role($role);

                
            // ➔ Mise à jour
            if ($user->updateUser()) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "✅ Utilisateur mis à jour avec succès."
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "❌ La mise à jour a échoué."
                ];
            }

            header("Location: /listUsers");
            exit();
        }

        require_once(__DIR__ . '/../Views/editUser.view.php');
    }




    public function deleteUser()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Sécurité : seul un admin peut supprimer un utilisateur
        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] !== 1) {
            header("Location: /");
            exit();
        }

        $id = $_GET['id'] ?? null;
        $currentUserId = $_SESSION['user']['id'];

        if ($id) {
            // 🔐 Empêche de supprimer soi-même
            if ($id == $currentUserId) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "❌ Vous ne pouvez pas supprimer votre propre compte."
                ];
            } else {
                $user = User::getUserById($id);
                if ($user) {
                    $user->deleteUser();
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => "✅ Utilisateur supprimé avec succès."
                    ];
                } else {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "❌ Utilisateur introuvable."
                    ];
                }
            }
        }

        header("Location: /listUsers");
        exit();
    }
}
