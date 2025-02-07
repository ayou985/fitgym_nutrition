<?php

namespace App\Controllers;
use App\Utils\AbstractController;
use App\Models\User;

class RegisterController extends AbstractController {
    public function index() {
        if (isset($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'])) {
            if (empty($this->arrayError)) {
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $firstName = htmlspecialchars($_POST['firstName']);
                $lastName = htmlspecialchars($_POST['lastName']);

                $id_role = 2; // Utilisateur par défaut

                // Hachage du mot de passe
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Création et sauvegarde de l'utilisateur
                $user = new User(null, $email, $passwordHash, $firstName, $lastName, null, null, $id_role);
                $user->save();

                $this->redirectToRoute('/login'); // Redirection après inscription
            }
        }
        require_once(__DIR__ . "/../Views/register.view.php");
    }
}
