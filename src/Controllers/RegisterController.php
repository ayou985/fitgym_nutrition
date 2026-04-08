<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;

class RegisterController extends AbstractController {
    public function register() {
        if (
            isset($_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['username'], $_POST['lastName'])
        ) {
            $email     = $_POST['email'];
            $password  = $_POST['password'];
            $confirm   = $_POST['confirm_password'];
            $username = $_POST['username'];
            $lastName  = $_POST['lastName'];

            // Validations
            $this->check('mail', $email);
            $this->check('password', $password);

            if ($password !== $confirm) {
                $this->arrayError['password'] = "❌ Les mots de passe ne correspondent pas.";
            }

            if (empty($this->arrayError)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $user = new User(null, $email, $hashedPassword, $username, $lastName, null, null, 2);
                $user->save();
                
                $this->redirectToRoute('/fitgym_nutrition-main/login');
            }
        }

        require_once(__DIR__ . '/../Views/register.view.php');
    }
}
