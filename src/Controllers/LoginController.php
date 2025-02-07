<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;

class LoginController extends AbstractController
{
    public function login()
    {
        session_start(); // Assurer que la session est bien démarrée

        $error = null; // Initialiser la variable pour éviter une erreur "Undefined variable"

        if (isset($_POST['mail'], $_POST['password'])) {
            $this->check('mail', $_POST['mail']);
            // $this->check('password', $_POST['password']);
            if (empty($this->arrayError)) {
                $mail = htmlspecialchars($_POST['mail']);
                $password = htmlspecialchars($_POST['password']);

                // Correction : Utilisation de $mail au lieu de $email
                $user = new User(null,  $mail, $password, null, null, null, null, null);
                $responseGetUser = $user->login($mail);

                if ($responseGetUser) {
                    $passwordUser = $responseGetUser->getPassword();

                    if (password_verify($password, $passwordUser)) {
                        $_SESSION['user'] = [
                            'id'          => $responseGetUser->getId(),
                            'email'       => $responseGetUser->getEmail(),
                            'firstName'   => $responseGetUser->getFirstName(),
                            'lastName'    => $responseGetUser->getLastName(),
                            'phoneNumber' => $responseGetUser->getPhoneNumber(),
                            'address'     => $responseGetUser->getAddress(),
                            'idRole'      => $responseGetUser->getIdRole()
                        ];
                        $this->redirectToRoute('/');
                        exit();
                    }
                    // Assurer que le script s'arrête après la redirection
                } else {
                    $error = "Le mail ou mot de passe n'est pas correct";
                }
            } else {
                $error = "Le mail ou mot de passe n'est pas correct";
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
