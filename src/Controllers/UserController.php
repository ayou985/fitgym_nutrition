<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    public function profile()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: /fitgym_nutrition-main/login");
            exit();
        }

        $user = User::getUserById($_SESSION['user']['id']);
        require_once(__DIR__ . "/../Views/profile.view.php");
    }

    public function updateProfile()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: /fitgym_nutrition-main/login");
            exit();
        }

        $id = $_SESSION['user']['id'];
        $email = $_POST['email'] ?? '';
        $username = $_POST['username'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $phoneNumber = $_POST['phoneNumber'] ?? '';
        $address = $_POST['address'] ?? '';
        
        $user = User::getUserById($id);

        if ($user && $email && $username && $lastName) {
            $user->setEmail($email)
                ->setusername($username)
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
                    
                    // Mise à jour immédiate de l'image en session
                    $_SESSION['user']['profile_image'] = $newName;
                }
            }

            // ✅ Gestion du mot de passe
            $oldPassword = $_POST['old_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (!empty($oldPassword) || !empty($newPassword) || !empty($confirmPassword)) {

                if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => '❌ Tous les champs de mot de passe doivent être remplis.'];
                    header("Location: /fitgym_nutrition-main/profile");
                    exit;
                }

                if (!password_verify($oldPassword, $user->getPassword())) {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => '❌ Ancien mot de passe incorrect.'];
                    header("Location: /fitgym_nutrition-main/profile");
                    exit;
                }

                if ($newPassword !== $confirmPassword) {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => '❌ Les mots de passe ne correspondent pas.'];
                    header("Location: /fitgym_nutrition-main/profile");
                    exit;
                }

                if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#?!@$%^&*-]).{8,}$/', $newPassword)) {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => "❌ Mot de passe trop faible."];
                    header("Location: /fitgym_nutrition-main/profile");
                    exit;
                }

                if (password_verify($newPassword, $user->getPassword())) {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => "❌ Le nouveau mot de passe ne peut pas être identique à l'ancien."];
                    header("Location: /fitgym_nutrition-main/profile");
                    exit;
                }

                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                \App\Models\User::updatePassword($user->getId(), $hashedPassword);

                session_destroy();
                session_start();
                $_SESSION['flash'] = ['type' => 'success', 'message' => '🔐 Mot de passe changé avec succès. Veuillez vous reconnecter.'];
                header("Location: /fitgym_nutrition-main/login");
                exit;
            }

            // ✅ MAJ infos utilisateur en Base de données
            $user->updateUser();

            // 🔥 SYNCHRONISATION DE LA SESSION (Pour corriger le bug de l'affichage)
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['lastName'] = $lastName;
            $_SESSION['user']['phoneNumber'] = $phoneNumber;
            $_SESSION['user']['address'] = $address;
            $_SESSION['user']['profile_image'] = $user->getProfileImage();

            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => "✅ Profil mis à jour avec succès."
            ];
            header("Location: /fitgym_nutrition-main/profile");
            exit;
        }
    }

    public function updateUser()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
            header("Location: /fitgym_nutrition-main/");
            exit();
        }

        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['id_Role'] ?? 2;

        if ($id && $name && $email) {
            $user = User::getUserById($id);

            if ($user) {
                $user->updateUser($name, $email, $role);
                $_SESSION['flash'] = ['type' => 'success', 'message' => "✅ Utilisateur mis à jour."];
            }
        }

        header("Location: /fitgym_nutrition-main/listUsers");
        exit();
    }

    public function deleteAccount()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user'])) {
            header("Location: /fitgym_nutrition-main/login");
            exit();
        }

        $id = $_SESSION['user']['id'];
        $user = User::getUserById($id);
        if($user) {
            $user->deleteUser();
        }
        
        session_destroy();
        header("Location: /fitgym_nutrition-main/");
        exit();
    }

    public function listUsers()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
            header("Location: /fitgym_nutrition-main/");
            exit();
        }

        $users = User::getAll();
        require_once(__DIR__ . '/../Views/listUsers.view.php');
    }

    public function editUser()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
            header("Location: /fitgym_nutrition-main/");
            exit();
        }

        $id = $_GET['id'] ?? null;
        $user = User::getUserById($id);

        if (!$user) {
            header("Location: /fitgym_nutrition-main/listUsers");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->setLastName($_POST['name'] ?? $user->getLastName())
                ->setusername($_POST['username'] ?? $user->getusername())
                ->setEmail($_POST['email'] ?? $user->getEmail())
                ->setId_Role($_POST['id_Role'] ?? $user->getIdRole());
                
            if ($user->updateUser()) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => "✅ Utilisateur mis à jour."];
            }

            header("Location: /fitgym_nutrition-main/listUsers");
            exit();
        }

        require_once(__DIR__ . '/../Views/editUser.view.php');
    }

    public function deleteUser()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
            header("Location: /fitgym_nutrition-main/");
            exit();
        }

        $id = $_GET['id'] ?? null;
        $user = User::getUserById($id);
        
        if ($id != $_SESSION['user']['id'] && $user) {
            $user->deleteUser();
            $_SESSION['flash'] = ['type' => 'success', 'message' => "✅ Utilisateur supprimé."];
        }

        header("Location: /fitgym_nutrition-main/listUsers");
        exit();
    }
}