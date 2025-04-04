<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;

class RegisterController extends AbstractController {
    public function register() {
        if (
            isset($_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['firstName'], $_POST['lastName'])
        ) {
            $email     = $_POST['email'];
            $password  = $_POST['password'];
            $confirm   = $_POST['confirm_password'];
            $firstName = $_POST['firstName'];
            $lastName  = $_POST['lastName'];

            // Validations
            $this->check('mail', $email);
            $this->check('password', $password);

            if ($password !== $confirm) {
                $this->arrayError['password'] = "❌ Les mots de passe ne correspondent pas.";
            }

            if (empty($this->arrayError)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $user = new User(null, $email, $hashedPassword, $firstName, $lastName, null, null, 2);
                $user->save();

                $this->redirectToRoute('/login');
            }
        }

        require_once(__DIR__ . '/../Views/register.view.php');
    }
}
